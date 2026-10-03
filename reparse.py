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
            
        branch_name = row[1].strip()
        phone = row[2].strip()
        address = row[3].strip()
        
        # If the row has a phone number or address, it's a new center (even if SL No is empty)
        if branch_name and (phone or address):
            if current_center:
                data.append(current_center)
            current_center = {
                'name': branch_name,
                'phone': phone,
                'address': address,
                'gmap': row[4].strip(),
                'instagram': row[5].strip(),
                'facebook': row[6].strip(),
                'linkedin': row[7].strip(),
                'activities': []
            }
        
        if current_center:
            # Parse activities
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
