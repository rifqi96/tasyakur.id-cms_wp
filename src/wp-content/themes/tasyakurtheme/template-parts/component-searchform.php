<form action="/index.php" method="get" class="search-form">
    <div class="form-group">
        <span class="icon fa fa-search"></span>
        <input type="text" name="s" class="form-control" placeholder="Type your keywords and hit enter">
        <?php
        $postType = get_post_type() ?: get_query_var('post_type')[0] ?? false;
        if ($postType)
            echo "<input type='hidden' name='post_type[]' value='". $postType ."'>";
        ?>
    </div>
</form>