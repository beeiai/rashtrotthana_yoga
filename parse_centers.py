import csv
import json

data = []
with open('centers.csv', 'r', encoding='utf-8') as f:
    reader = csv.reader(f)
    headers = next(reader)
    
    current_center = None
    
    for row in reader:
        if not any(row):
            continue
            
        sl_no = row[0].strip()
        if sl_no:
            if current_center:
                data.append(current_center)
            current_center = {
                'name': row[1].strip(),
                'phone': row[2].strip(),
                'address': row[3].strip(),
                'gmap': row[4].strip(),
                'instagram': row[5].strip(),
                'facebook': row[6].strip(),
                'linkedin': row[7].strip(),
                'activities': []
            }
        
        # Parse activities from the remaining columns
        # Column 8 is the activity name, Column 9 is the timing
        act_name = row[8].strip()
        act_time = row[9].strip() if len(row) > 9 else ""
        
        # Sometimes there are multiple activities in one row across columns?
        # Looking at the data:
        # Col 8: Activity 1 Name
        # Col 9: Activity 1 Time
        # Col 10: Activity 2 Name (e.g. Light Music)
        # Col 11: Activity 2 Time
        # Col 12: Activity 3 Name
        # Col 13: Activity 3 Time
        # Col 14: Activity 4 Name
        # Col 15: Activity 4 Time
        
        for i in range(8, len(row), 2):
            if i < len(row):
                name = row[i].strip()
                time = row[i+1].strip() if i+1 < len(row) else ""
                if name:
                    current_center['activities'].append({'name': name, 'time': time})

    if current_center:
        data.append(current_center)

with open('parsed_centers.json', 'w', encoding='utf-8') as f:
    json.dump(data, f, indent=4)
