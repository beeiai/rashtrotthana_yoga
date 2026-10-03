import os

filepath = 'wp-content/themes/rashtrotthana/template-parts/home/homepage-sections.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

# Fix Activities
old_activities = '''        <div class="rs-card-grid rs-activity-grid">
            <?php if (  ) : foreach (  as  ) : setup_postdata(  ); ?>
                <article class="rs-activity-card"><a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'class' => 'rs-activity-uniform-img' ) ); } ?><h3><?php the_title(); ?></h3></a></article>
            <?php endforeach; wp_reset_postdata(); else : foreach (  as  ) : ?>
                <article class="rs-activity-card"><img class="rs-activity-uniform-img" src="<?php echo esc_url( [2] ); ?>" alt="" loading="lazy"><h3><?php echo esc_html( [0] ); ?></h3></article>
            <?php endforeach; endif; ?>
        </div>'''
new_activities = '''        <div class="rs-card-grid rs-activity-grid">
            <article class="rs-activity-card"><img class="rs-activity-uniform-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/client/21-06-22-idy-celebration-12-.jpg' ); ?>" alt="Yoga" loading="lazy"><h3>Yoga</h3></article>
            <article class="rs-activity-card"><img class="rs-activity-uniform-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg' ); ?>" alt="Gym" loading="lazy"><h3>Gym</h3></article>
            <article class="rs-activity-card"><img class="rs-activity-uniform-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg' ); ?>" alt="Music and Dance" loading="lazy"><h3>Music and Dance</h3></article>
            <article class="rs-activity-card"><img class="rs-activity-uniform-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/client/rashtrotthana-yoga-center.jpg' ); ?>" alt="Karate" loading="lazy"><h3>Karate</h3></article>
        </div>'''
content = content.replace(old_activities, new_activities)

# Fix Centers
old_centers = '''        <div class="rs-card-grid rs-center-cards">
            <?php foreach (  as  ) : ?>
                <article class="rs-center-card">
                    <img src="<?php echo esc_url( ['image'] ); ?>" alt="" loading="lazy">
                    <h3><?php echo esc_html( ['name'] ); ?></h3>
                    <p><?php echo esc_html( ['desc'] ); ?></p>
                    <a href="<?php echo esc_url( home_url('/centers/') ); ?>">View Details</a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>'''
new_centers = '''        <div class="rs-card-grid rs-activity-grid rs-center-cards">
            <?php foreach (  as  ) : ?>
                <article class="rs-center-card" style="flex: 0 0 280px; display: flex; flex-direction: column;">
                    <div class="rs-center-card-img-wrap" style="height: 160px; overflow: hidden;">
                        <img src="<?php echo esc_url( ['image'] ); ?>" alt="<?php echo esc_attr( ['name'] ); ?>" loading="lazy" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div class="rs-center-card-body" style="padding: 16px; flex-grow: 1; display: flex; flex-direction: column;">
                        <h3 style="margin:0 0 4px; font-size:1.1rem;"><?php echo esc_html( ['name'] ); ?></h3>
                        <p style="margin:0 0 16px; font-size:0.9rem; color:#666; flex-grow:1;"><?php echo esc_html( ['desc'] ); ?></p>
                        <button class="rs-center-button rs-open-center-modal-btn" data-modal="center-modal-<?php echo esc_attr( ['id'] ); ?>" style="margin-top:auto; width:100%; justify-content:center; border:none; cursor:pointer;">
                            <span>View Details</span>
                            <span aria-hidden="true">&rarr;</span>
                        </button>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php 
// Include modals for all centers
foreach (  as  ) {
    include locate_template('template-parts/center-modal.php');
}
?>'''
content = content.replace(old_centers, new_centers)

script_js = '''
<script>
document.addEventListener('DOMContentLoaded', function () {
    var body = document.body;
    
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        body.classList.add('rs-center-modal-open');
        var closeBtn = modal.querySelector('.rs-center-modal-close');
        if (closeBtn) closeBtn.focus();
    }

    function closeModal() {
        document.querySelectorAll('.rs-center-modal.is-open').forEach(function (modal) {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        });
        body.classList.remove('rs-center-modal-open');
    }

    document.addEventListener('click', function (e) {
        var openBtn = e.target.closest('.rs-open-center-modal-btn');
        if (openBtn) {
            e.preventDefault();
            e.stopPropagation();
            var modalId = openBtn.dataset.modal;
            if (modalId) openModal(modalId);
            return;
        }

        if (e.target.matches('[data-close-modal="true"]') || e.target.closest('[data-close-modal="true"]')) {
            e.preventDefault();
            closeModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
});
</script>
'''

if script_js not in content:
    content += script_js

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
