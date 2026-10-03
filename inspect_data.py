import re

with open('wp-content/themes/rashtrotthana/inc/data-helpers.php', 'r', encoding='utf-8') as f:
    text = f.read()

text = text.replace("'post_type' => 'event'", "'post_type' => 'rs_event'")

# Remove the fallback entirely so it strictly aligns with the DB?
# The user said: "Ensure all these are alligining with the admin poratl also"
# If we remove the fallback, they will see NOTHING if the DB is empty.
# Let's remove the fallback from s_get_events() and s_get_news().

# Actually, let's keep the fallback ONLY if empty, but maybe they ARE empty?
# Wait, for news, the user pasted "Hello World", which means the fallback WAS APPENDED to the DB results!
# Let's check how the fallback is appended.
