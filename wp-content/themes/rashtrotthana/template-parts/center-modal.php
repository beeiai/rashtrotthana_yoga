<?php
/**
 * Template Part: Center Details Modal
 *
 * @package Rashtrotthana
 * @var array $args Passed center data
 */
$center = ! empty( $args['center'] ) ? $args['center'] : ( isset( $center ) ? $center : array() );
if ( empty( $center ) ) {
    return;
}

$center_activities = ! empty( $center['activity_details'] ) ? $center['activity_details'] : ( function_exists('rs_get_center_detailed_activities') ? rs_get_center_detailed_activities( $center ) : array() );
$center_op_hours   = ! empty( $center['operation_hours'] ) ? $center['operation_hours'] : ( function_exists('rs_get_center_op_hours') ? rs_get_center_op_hours( $center ) : '' );
$center_id         = ! empty( $center['id'] ) ? $center['id'] : sanitize_title( $center['name'] ?? 'center' );
?>
<div class="rs-center-modal" id="center-modal-<?php echo esc_attr( $center_id ); ?>" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="center-modal-title-<?php echo esc_attr( $center_id ); ?>">
    <div class="rs-center-modal-backdrop" data-close-modal="true"></div>
    <div class="rs-center-modal-container">
        <article class="rs-center-modal-card">
            <button type="button" class="rs-center-modal-close" aria-label="Close center details" data-close-modal="true">✕</button>

            <div class="rs-center-modal-header">
                <div class="rs-center-modal-meta">
                    <span class="rs-center-modal-zone-badge"><?php echo esc_html( $center['zone'] ?? 'Zone' ); ?></span>
                    <span class="rs-center-modal-dot" aria-hidden="true">•</span>
                    <span class="rs-center-modal-kicker">RASHTROTTHANA YOGA</span>
                </div>
                <h2 class="rs-center-modal-title" id="center-modal-title-<?php echo esc_attr( $center_id ); ?>">
                    <?php echo esc_html( $center['name'] ?? '' ); ?>
                </h2>
                <p class="rs-center-modal-address">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span><?php echo esc_html( $center['address'] ?? '' ); ?></span>
                </p>
            </div>

            <div class="rs-center-modal-divider" aria-hidden="true"></div>

            <!-- Quick Specs Grid: Operation Hours, Direct Phone & Email Address -->
            <div class="rs-center-specs-grid">
                <?php if ( ! empty( $center_op_hours ) ) : ?>
                    <div class="rs-spec-item rs-spec-op-hours">
                        <span class="rs-spec-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </span>
                        <div class="rs-spec-content">
                            <strong>Operation Hours</strong>
                            <p><?php echo esc_html( $center_op_hours ); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $center['phone'] ) ) : ?>
                    <div class="rs-spec-item">
                        <span class="rs-spec-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <div class="rs-spec-content">
                            <strong>Direct Phone</strong>
                            <p><a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $center['phone']) ); ?>"><?php echo esc_html( $center['phone'] ); ?></a></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $center['email'] ) ) : ?>
                    <div class="rs-spec-item">
                        <span class="rs-spec-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </span>
                        <div class="rs-spec-content">
                            <strong>Email Address</strong>
                            <p><a href="mailto:<?php echo esc_attr( $center['email'] ); ?>"><?php echo esc_html( $center['email'] ); ?></a></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Branch Social Links (Instagram, Facebook, Linktree) -->
            <?php if ( ! empty( $center['instagram_url'] ) || ! empty( $center['facebook_url'] ) || ! empty( $center['linktree_url'] ) ) : ?>
                <div class="rs-center-modal-socials">
                    <span class="rs-center-socials-label">Connect with this branch:</span>
                    <div class="rs-center-socials-links">
                        <?php if ( ! empty( $center['instagram_url'] ) ) : ?>
                            <a href="<?php echo esc_url( $center['instagram_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="rs-center-social-btn rs-social-ig" title="Follow <?php echo esc_attr( $center['name'] ?? '' ); ?> on Instagram" aria-label="Instagram">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>
                                <span>Instagram</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $center['facebook_url'] ) ) : ?>
                            <a href="<?php echo esc_url( $center['facebook_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="rs-center-social-btn rs-social-fb" title="Visit <?php echo esc_attr( $center['name'] ?? '' ); ?> on Facebook" aria-label="Facebook">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                                <span>Facebook</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $center['linktree_url'] ) ) : ?>
                            <a href="<?php echo esc_url( $center['linktree_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="rs-center-social-btn rs-social-lt" title="Branch Links on Linktree" aria-label="Linktree">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </svg>
                                <span>Linktree</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Activities Section with Batch Details Nested Inside Each Card -->
            <?php if ( ! empty( $center_activities ) ) : ?>
                <div class="rs-center-modal-section">
                    <div class="rs-center-modal-section-header">
                        <div>
                            <h3 class="rs-center-modal-section-title">Activities</h3>
                            <p class="rs-center-modal-section-subtitle">Certified yoga programs and classes conducted at this center along with complete batch details.</p>
                        </div>
                    </div>
                    <div class="rs-center-activities-grid">
                        <?php foreach ( $center_activities as $act ) : ?>
                            <div class="rs-center-activity-card">
                                <div class="rs-center-act-top">
                                    <h4 class="rs-center-act-title"><?php echo esc_html( $act['name'] ); ?></h4>
                                    <?php if ( ! empty( $act['badge'] ) ) : ?>
                                        <span class="rs-center-act-badge"><?php echo esc_html( $act['badge'] ); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if ( ! empty( $act['desc'] ) ) : ?>
                                    <p class="rs-center-act-desc"><?php echo esc_html( $act['desc'] ); ?></p>
                                <?php endif; ?>

                                <!-- Batch Details inside the Activity Card -->
                                <div class="rs-center-act-batch-details">
                                    <div class="rs-center-act-batch-header">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span class="rs-center-act-batch-title">Batch Details</span>
                                    </div>
                                    <div class="rs-center-act-details">
                                        <?php if ( ! empty( $act['timings'] ) ) : ?>
                                            <div class="rs-center-act-detail-row">
                                                <span class="rs-act-detail-icon" aria-hidden="true">
                                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                </span>
                                                <span class="rs-act-detail-text"><strong>Timings:</strong> <?php echo esc_html( $act['timings'] ); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $act['days'] ) ) : ?>
                                            <div class="rs-center-act-detail-row">
                                                <span class="rs-act-detail-icon" aria-hidden="true">
                                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                                </span>
                                                <span class="rs-act-detail-text"><strong>Batches &amp; Days:</strong> <?php echo esc_html( $act['days'] ); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $act['dates'] ) ) : ?>
                                            <div class="rs-center-act-detail-row">
                                                <span class="rs-act-detail-icon" aria-hidden="true">
                                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                                </span>
                                                <span class="rs-act-detail-text"><strong>Admissions:</strong> <?php echo esc_html( $act['dates'] ); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Facility Highlights -->
            <?php if ( ! empty( $center['features'] ) ) : ?>
                <div class="rs-center-modal-section">
                    <h3 class="rs-center-modal-section-title">Facility Highlights</h3>
                    <div class="rs-center-modal-features">
                        <?php foreach ( $center['features'] as $feat ) : ?>
                            <div class="rs-modal-feature-badge">
                                <span class="rs-feature-check">✓</span>
                                <span><?php echo esc_html( $feat ); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Modal Actions -->
            <div class="rs-center-modal-footer">
                <p class="rs-center-modal-footer-note">
                    Need personalized batch timings or trial classes? Reach out directly to this center.
                </p>
                <div class="rs-center-modal-actions">
                    <?php 
                    $directions_url = ! empty( $center['map_url'] ) ? $center['map_url'] : ( 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( 'Rashtrotthana Yoga ' . ( $center['name'] ?? '' ) . ' ' . ( $center['address'] ?? '' ) ) );
                    $enquire_url    = add_query_arg( array(
                        'topic'  => 'center-inquiry',
                        'center' => $center['name'] ?? '',
                    ), home_url( '/contact-us/' ) );
                    ?>
                    <a href="<?php echo esc_url( $directions_url ); ?>" target="_blank" rel="noopener" class="rs-center-modal-directions-btn">
                        <span>Get Directions ↗</span>
                    </a>
                    <a href="<?php echo esc_url( $enquire_url ); ?>" class="rs-center-modal-enquire-btn">
                        <span>Enquire Now →</span>
                    </a>
                </div>
            </div>
        </article>
    </div>
</div>
