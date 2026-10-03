text = open('wp-content/plugins/rashtrotthana-admin/pages/registrations.php', encoding='utf-8').read()

s1 = """     = [
        'Jayanagar', 'Basavanagudi', 'Malleshwaram',
        'Indiranagar', 'Whitefield', 'HSR Layout',
        'Rajarajeshwari Nagar', 'Whitefield 2', 'Koramangala',
        'Yelahanka', 'Electronic City', 'Hebbal',
    ];"""

s1_new = """     = [];
     = get_posts([
        'post_type'      => 'rs_center',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC'
    ]);
    foreach ( as ) {
        [] = ->post_title;
    }"""

text = text.replace(s1, s1_new)

s2 = """     = [
        'Jayanagar','Basavanagudi','Malleshwaram','Indiranagar',
        'Whitefield','HSR Layout','Rajarajeshwari Nagar','Whitefield 2',
        'Koramangala','Yelahanka','Electronic City','Hebbal',
    ];"""

s2_new = """     = [];
     = get_posts([
        'post_type'      => 'rs_center',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC'
    ]);
    foreach ( as ) {
        [] = ->post_title;
    }"""

text = text.replace(s2, s2_new)

with open('wp-content/plugins/rashtrotthana-admin/pages/registrations.php', 'w', encoding='utf-8') as f:
    f.write(text)
