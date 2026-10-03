$file = 'wp-content/themes/rashtrotthana/template-parts/home/homepage-sections.php';
$content = file_get_contents($file);

// Remove activity fallback
$content = preg_replace('/else : foreach \( \$activity_fallbacks as \$item \) : \?>.*?<\?php endforeach; /s', '', $content);
$content = preg_replace('/else : foreach \( \$event_fallbacks as \$item \) : \?>.*?<\?php endforeach; /s', '', $content);
// Also for centers?
$content = preg_replace('/else : foreach \( \$rs_home_cards as \$card \) : \?>.*?<\?php endforeach; /s', '', $content);

file_put_contents($file, $content);
echo "Cleaned fallbacks from homepage-sections.php\n";
