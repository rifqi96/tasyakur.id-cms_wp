<?php
the_content();
?>

<div class="pt-5">
    <p>
        Categories:
        <?php
        $categories = get_categories();
        foreach($categories as $i => $category) {
            $catLink = '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
            if ($i < count($categories))
                $catLink .= ', ';
            echo $catLink;
        }
        ?>
        <?the_tags()?>
    </p>
</div>
