<?php get_header(); ?>

<?php
$activity_categories = array(
    array( 'icon' => '☯', 'title' => 'Yoga & Wellness', 'text' => 'Yoga practices that build strength, flexibility, balance and inner calm.', 'items' => array( 'Yoga for Beginners', 'Yoga for All', 'Yoga Therapy Sessions', 'Prenatal Yoga' ) ),
    array( 'icon' => '♫', 'title' => 'Arts & Music', 'text' => 'Nurturing creativity and harmony through classical and contemporary music learning.', 'items' => array( 'Carnatic Music', 'Keyboard', 'Light Music', 'Flute' ) ),
    array( 'icon' => '♬', 'title' => 'Dance', 'text' => 'Traditional dance forms that preserve our rich cultural heritage.', 'items' => array( 'Bharatanatyam', 'Kathak', 'Folk Dance', 'Contemporary Dance' ) ),
    array( 'icon' => '★', 'title' => 'Martial Arts', 'text' => 'Self-defence and discipline-building through structured physical training.', 'items' => array( 'Karate', 'Taekwondo', 'Kalaripayattu', 'Self Defence' ) ),
    array( 'icon' => '☺', 'title' => 'Children Programs', 'text' => 'Value-based education and holistic development programs for children.', 'items' => array( 'Samskrita Bala Kendra', 'Bala Samskara Kendra', 'Personality Development', 'Summer Camps' ) ),
    array( 'icon' => '⌁', 'title' => 'Fitness & Sports', 'text' => 'Build strength, stamina and confidence with sports and fitness facilities.', 'items' => array( 'Gym', 'Swimming Pool', 'Table Tennis', 'Chess' ) ),
    array( 'icon' => '✿', 'title' => 'Health & Therapy', 'text' => 'Therapeutic programs and natural healing for a healthier life.', 'items' => array( 'Counselling Centre', 'Acupressure & Colour Therapy', 'Yoga Therapy', 'Body Massage' ) ),
    array( 'icon' => '▤', 'title' => 'Knowledge & Culture', 'text' => 'Programs that inspire wisdom, values, culture and personal growth.', 'items' => array( 'Kannada Coaching', 'Vishwa Samskrama Classes', 'Bhagavadgita', 'Calligraphy' ) ),
);
?>

<main class="rs-activities-page">
    <section class="rs-activities-hero">
        <div class="rs-activities-hero-image" aria-hidden="true"></div>
        <div class="rs-container rs-activities-hero-inner">
            <div class="rs-activities-copy">
                <p class="rs-activities-breadcrumb">Home <span>›</span> Activities</p>
                <h1>Our <em>Activities</em></h1>
                <h2>Nurturing Body, Mind and Spirit</h2>
                <p>Discover a wide range of programs designed to promote holistic well-being, cultural values, fitness and personal development for all age groups.</p>
                <div class="rs-activities-stats">
                    <div><strong>35+</strong><span>Activities</span></div>
                    <div><strong>23+</strong><span>Centers</span></div>
                    <div><strong>100+</strong><span>Instructors</span></div>
                    <div><strong>1.5+ Lakh</strong><span>Lives Touched</span></div>
                </div>
            </div>
        </div>
    </section>

    <section class="rs-activity-tabs" aria-label="Activity categories"><div class="rs-container"><div class="rs-activity-tab-list">
        <a class="is-active" href="#all">▦ <span>All Activities</span></a>
        <?php foreach ( $activity_categories as $category ) : ?><a href="#<?php echo esc_attr( sanitize_title( $category['title'] ) ); ?>"><b><?php echo esc_html( $category['icon'] ); ?></b><span><?php echo esc_html( $category['title'] ); ?></span></a><?php endforeach; ?>
    </div></div></section>

    <section class="rs-activities-intro"><div class="rs-container"><div><span class="rs-intro-lotus">✿</span><p>Each activity is guided by experienced instructors who are committed to your growth and well-being.</p><a href="#categories">Know More About Us <span>→</span></a></div></div></section>

    <section class="rs-activities-categories" id="categories"><div class="rs-container">
        <div class="rs-activities-heading"><p>FIND YOUR PRACTICE</p><h2>Explore Our Activity Categories</h2></div>
        <div class="rs-activities-grid" id="all">
            <?php foreach ( $activity_categories as $category ) : ?><article class="rs-activity-category" id="<?php echo esc_attr( sanitize_title( $category['title'] ) ); ?>"><i><?php echo esc_html( $category['icon'] ); ?></i><h3><?php echo esc_html( $category['title'] ); ?></h3><p><?php echo esc_html( $category['text'] ); ?></p><ul><?php foreach ( $category['items'] as $item ) : ?><li><?php echo esc_html( $item ); ?></li><?php endforeach; ?></ul><a href="#contact">View Activities <span>→</span></a></article><?php endforeach; ?>
        </div>
    </div></section>

    <section class="rs-activities-finder" id="contact"><div class="rs-container"><div><span>▣</span><p><strong>Looking for a specific activity near you?</strong><small>Find out which activities are available at your nearest center.</small></p><a href="#">⌖ &nbsp; Find a Center Near You</a></div></div></section>
</main>

<?php get_footer(); ?>
