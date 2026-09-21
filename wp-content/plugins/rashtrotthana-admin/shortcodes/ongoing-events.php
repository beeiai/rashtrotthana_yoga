<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function ry_ongoing_events_shortcode() {
    $now_date = current_time( 'Y-m-d' );
    
    // Query active events where registration end date has not passed
    $events = get_posts( [
        'post_type'      => 'event',
        'post_status'    => 'publish',
        'numberposts'    => -1,
        'orderby'        => 'meta_value',
        'meta_key'       => '_ry_event_date',
        'order'          => 'ASC',
        'meta_query'     => [
            'relation' => 'AND',
            [
                'key'     => '_ry_registration_open',
                'value'   => '1',
                'compare' => '='
            ],
            [
                'relation' => 'OR',
                [
                    'key'     => '_ry_reg_last_date',
                    'value'   => $now_date,
                    'compare' => '>=',
                    'type'    => 'DATE'
                ],
                [
                    'key'     => '_ry_reg_last_date',
                    'value'   => '',
                    'compare' => '='
                ],
                [
                    'key'     => '_ry_reg_last_date',
                    'compare' => 'NOT EXISTS'
                ]
            ]
        ]
    ] );

    if ( empty( $events ) ) {
        return '<div style="padding:40px;text-align:center;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;margin:40px 0;">
                    <h3 style="margin:0;color:#334155;font-size:1.25rem;">No Ongoing Registrations</h3>
                    <p style="margin:10px 0 0;color:#64748b;">There are currently no events open for registration. Please check back later.</p>
                </div>';
    }

    ob_start();
    ?>
    <style>
        .ry-ongoing-events-table {
            width: 100%;
            border-collapse: collapse;
            margin: 40px 0;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
            font-family: inherit;
        }
        .ry-ongoing-events-table th, 
        .ry-ongoing-events-table td {
            padding: 16px 20px;
            text-align: left;
        }
        .ry-ongoing-events-table thead {
            background: #f1f5f9;
            border-bottom: 2px solid #e2e8f0;
        }
        .ry-ongoing-events-table th {
            font-weight: 600;
            color: #334155;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .ry-ongoing-events-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s ease;
        }
        .ry-ongoing-events-table tbody tr:hover {
            background: #f8fafc;
        }
        .ry-ongoing-events-table td {
            color: #475569;
            font-size: 0.95rem;
            vertical-align: top;
        }
        .ry-event-title {
            font-weight: 600;
            color: #0f172a;
            margin: 0 0 4px 0;
            font-size: 1.1rem;
        }
        .ry-event-desc {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .ry-event-badge {
            display: inline-block;
            background: #e0f2fe;
            color: #0284c7;
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 6px;
        }
        .ry-register-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            background: var(--rs-primary-color, #c2410c);
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .ry-register-btn:hover {
            background: var(--rs-primary-hover, #9a3412);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(194, 65, 12, 0.2);
        }
        @media (max-width: 768px) {
            .ry-ongoing-events-table thead { display: none; }
            .ry-ongoing-events-table, .ry-ongoing-events-table tbody, .ry-ongoing-events-table tr, .ry-ongoing-events-table td { display: block; width: 100%; }
            .ry-ongoing-events-table tr { margin-bottom: 16px; border: 1px solid #e2e8f0; border-radius: 12px; }
            .ry-ongoing-events-table td { padding: 12px 16px; text-align: left; position: relative; border-bottom: 1px solid #f1f5f9; }
            .ry-ongoing-events-table td:last-child { border-bottom: 0; }
            .ry-ongoing-events-table td::before { content: attr(data-label); font-weight: 600; color: #334155; display: block; margin-bottom: 4px; font-size: 0.85rem; text-transform: uppercase; }
            .ry-event-title-cell::before { display: none !important; }
        }
    </style>

    <div style="overflow-x:auto;">
        <table class="ry-ongoing-events-table">
            <thead>
                <tr>
                    <th>Event Details</th>
                    <th>Event Date</th>
                    <th>Location(s)</th>
                    <th>Registration Closes</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $events as $event ) : 
                    $event_date    = get_post_meta( $event->ID, '_ry_event_date', true );
                    $reg_last_date = get_post_meta( $event->ID, '_ry_reg_last_date', true );
                    $centers       = get_post_meta( $event->ID, '_ry_event_centers', true );
                    $use_gf        = get_post_meta( $event->ID, '_ry_use_google_form', true );
                    $gf_url        = get_post_meta( $event->ID, '_ry_google_form_url', true );
                    
                    $center_names = is_array( $centers ) ? array_map('ucwords', array_map('str_replace', array_fill(0, count($centers), '-'), array_fill(0, count($centers), ' '), $centers)) : [];
                    $center_text  = !empty( $center_names ) ? implode(', ', $center_names) : 'Multiple Centers';
                    
                    $link_url = ( $use_gf && $gf_url ) ? esc_url( $gf_url ) : '#';
                    $link_target = ( $use_gf && $gf_url ) ? '_blank' : '_self';
                ?>
                <tr>
                    <td class="ry-event-title-cell" data-label="Event Details">
                        <span class="ry-event-badge">Upcoming</span>
                        <h4 class="ry-event-title"><?php echo esc_html( $event->post_title ); ?></h4>
                        <p class="ry-event-desc"><?php echo esc_html( wp_trim_words( $event->post_content, 20 ) ); ?></p>
                    </td>
                    <td data-label="Event Date" style="white-space: nowrap;">
                        <strong><?php echo $event_date ? date( 'd M Y', strtotime( $event_date ) ) : 'TBA'; ?></strong>
                    </td>
                    <td data-label="Location(s)">
                        <?php echo esc_html( $center_text ); ?>
                    </td>
                    <td data-label="Registration Closes" style="white-space: nowrap; color: #dc2626; font-weight: 500;">
                        <?php echo $reg_last_date ? date( 'd M Y', strtotime( $reg_last_date ) ) : 'Open Until Full'; ?>
                    </td>
                    <td data-label="Action" style="text-align:right; white-space:nowrap;">
                        <?php if ( $use_gf && $gf_url ) : ?>
                            <a href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>" class="ry-register-btn" rel="noopener noreferrer">
                                Register Here &nbsp;↗
                            </a>
                        <?php else : ?>
                            <a href="#" class="ry-register-btn" onclick="alert('Internal registration form opening...'); return false;">
                                Register Now &nbsp;→
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'ry_ongoing_events', 'ry_ongoing_events_shortcode' );
