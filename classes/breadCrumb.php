<?php
function breadcrumbs($separator = ' &raquo; ', $home = 'Coderrat') {
    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    $base = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    
    $breadcrumbs = Array("<span itemprop='itemListElement' itemscope
      itemtype='https://schema.org/ListItem' ><a itemprop='item' class='breadCrumb' href=\"$base\"><span itemprop='name'>$home</span></a><meta itemprop='position' content='1' /></span>");
    $last = end(array_keys($path));
    foreach ($path AS $x => $crumb) {
        $title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb));
        $title_url = strtolower($title);
        if ($x != $last)
            $breadcrumbs[] = "<span itemprop='itemListElement' itemscope
      itemtype='https://schema.org/ListItem' ><a itemprop='item' class='breadCrumb' href=\"$base$crumb\"><span itemprop='name'>$title</span></a><meta itemprop='position' content='2'/></span>";
        else
            $breadcrumbs[] = "<span itemprop='itemListElement' itemscope
      itemtype='https://schema.org/ListItem' ><a itemprop='item' class='breadCrumb' href=\"$base$title_url\"><span itemprop='name'>$title</span></a><meta itemprop='position' content='2'/></span>";
    }
   
    return implode($separator, $breadcrumbs);
}
