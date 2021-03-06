<?php
/**
 * site: https://github.com/xingshaocheng/simple-php-github-toc 
 */

if(count($argv) < 2){
        exit("Please input github file url, eg 'php github-toc.php https://github.com/xingshaocheng/architect-awesome/blob/master/README.md'.\n");
}

$url = $argv[1]; 

#$url = "https://github.com/xingshaocheng/architect-awesome/blob/master/README.md";


function get_anchor($content){
        preg_match_all("/href=\"(.*)\">/iUs",  $content, $anchor_arr);
        if(count($anchor_arr) > 0){
                return $anchor_arr[1][0];
        }
        return "";
}

function get_title($content){
        preg_match_all("/a\>(.*)$/iUs",  $content, $title_arr);
        if(count($title_arr) > 0){
                return trim($title_arr[1][0]);
        }
        return "";
}

$content = file_get_contents($url);

preg_match_all("/<article(.*)<\/article>/iUs", $content, $article);

$article_html = $article[0][0];

preg_match_all("/<h([1-6])>(.*)<\/h[1-6]{1}>/iUs",  $article_html, $each_head); 

$len = count($each_head[0]);
for($i = 0;$i < $len; $i++){
        $level = $each_head[1][$i];
        $each_content = $each_head[2][$i];
        $anchor = get_anchor($each_content);
        $title = get_title($each_content);
        echo str_repeat("\t",($level-1)),"* ","[${title}](${url}${anchor})\n";
}

echo "\n TOC generated by [simple-php-github-toc](https://github.com/xingshaocheng/simple-php-github-toc) \n\n ";
