function PageToLinks($slug = 'links')
{
    $db = Typecho_Db::get();
    
    $contents = $db->fetchObject($db->select('text')->from('table.contents')
    ->where('slug = ?', $slug)->limit(1));
    if (!$contents) {
        return;
    }
    $text = $contents->text;
    $titles = $db->fetchObject($db->select('title')->from('table.contents')
    ->where('slug = ?', $slug)->limit(1));
    $title=$titles->title;

    preg_match_all("/\[(.*?)\]\[(\d)\]/", $text,$r);
    echo "<h3 class='widget-title'>".$title."</h3>";
    echo "<ul class='widget-list'>";
    foreach ($r[1] as $key => $value) {
        $num=$r[2][$key];
        preg_match_all("/\[$num\]:\s(.*?)\s/", $text, $urls);
        $href="<a href=".$urls[1][0].">".$value."</a>";
        echo "<li>".$href."</li>";
    }
    echo "</ul>";
}