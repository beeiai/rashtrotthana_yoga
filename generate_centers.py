import csv
import json

existing_locations = {
    'jayanagar': {'lat': 12.9250, 'lng': 77.5938, 'zone': 'South Bengaluru', 'zone_slug': 'south'},
    'vijayanagar': {'lat': 12.9698, 'lng': 77.5358, 'zone': 'West Bengaluru', 'zone_slug': 'west'},
    'nagarbhavi': {'lat': 12.9602, 'lng': 77.5103, 'zone': 'West Bengaluru', 'zone_slug': 'west'},
    'kundalahalli': {'lat': 12.9698, 'lng': 77.7499, 'zone': 'East Bengaluru', 'zone_slug': 'east'},
    'sadashivnagar': {'lat': 13.0068, 'lng': 77.5813, 'zone': 'Central Bengaluru', 'zone_slug': 'central'},
}

csv_centers = []
current_center = None

with open(r'C:\Users\sande\Downloads\Yoga Information - Sheet1.csv', 'r', encoding='utf-8') as f:
    reader = csv.reader(f)
    next(reader) # skip header
    for row in reader:
        if not any(row): continue
        if row[1].strip() != '': # New center
            current_center = {
                'name': row[1].strip(),
                'phone': row[2].strip(),
                'address': row[3].strip(),
                'map': row[4].strip(),
                'instagram': row[5].strip(),
                'facebook': row[6].strip(),
                'linkedin': row[7].strip(),
                'activities': []
            }
            csv_centers.append(current_center)
        
        # Check activities
        for i in range(8, len(row), 2):
            if i < len(row) and row[i].strip() != '':
                act_name = row[i].strip()
                act_time = row[i+1].strip() if i+1 < len(row) else ''
                if current_center is not None:
                    current_center['activities'].append({'name': act_name, 'time': act_time})


php_output = "<?php\n/**\n * Centers Data — Rashtrotthana Yoga\n * Auto-generated from Excel sheet data.\n */\n$centers = array(\n"

for c in csv_centers:
    name = c['name']
    c_id = name.lower().replace(' ', '').replace(',', '')
    
    loc = {'lat': 12.9716, 'lng': 77.5946, 'zone': 'Bengaluru', 'zone_slug': 'bengaluru'}
    for k, v in existing_locations.items():
        if k in c_id:
            loc = v
            break
            
    programs = [a['name'] for a in c['activities']]
    programs_php = ', '.join(["'" + p.replace("'", "") + "'" for p in programs])
    
    act_details_php = "array(\n"
    for a in c['activities']:
        badge = 'Specialized'
        aname = a['name'].lower()
        if 'beginner' in aname: badge = 'Foundational'
        elif 'general' in aname: badge = 'Daily Batches'
        elif 'therapy' in aname: badge = 'Personalized Care'
        elif 'senior' in aname: badge = 'Senior Care'
        elif 'children' in aname or 'junior' in aname: badge = 'Children'
        
        act_details_php += f"""        array(
            'name' => '{a['name'].replace("'", "\\'")}',
            'badge' => '{badge}',
            'days' => 'As per schedule',
            'timings' => '{a['time'].replace("'", "\\'")}',
            'dates' => 'Ongoing',
            'desc' => 'Certified Rashtrotthana Yoga instruction for {a['name'].replace("'", "\\'")}.'
        ),\n"""
    act_details_php += "    )"

    php_output += f"""    array(
        'id' => '{c_id}',
        'name' => '{name.replace("'", "\\'")}',
        'area' => '{name.replace("'", "\\'")}',
        'zone' => '{loc['zone']}',
        'zone_slug' => '{loc['zone_slug']}',
        'lat' => {loc['lat']},
        'lng' => {loc['lng']},
        'phone' => '{c['phone'].replace("'", "\\'")}',
        'hours' => 'Please refer to batch timings',
        'timing' => 'both',
        'timing_label' => 'Morning & Evening',
        'programs' => array({programs_php}),
        'activities' => array('yoga', 'wellness'),
        'address' => '{c['address'].replace("'", "\\'").replace(chr(10), ' ')}',
        'email' => 'info@rashtrotthana.org',
        'image' => get_template_directory_uri() . '/assets/images/client/20200529-175453.jpg',
        'features' => array('Certified Instructors', 'Spacious Shala'),
        'activity_details' => {act_details_php},
    ),\n"""

php_output += ");\n"

with open('wp-content/themes/rashtrotthana/data/centers-data.php', 'w', encoding='utf-8') as f:
    f.write(php_output)
print("Generated centers-data.php successfully")
