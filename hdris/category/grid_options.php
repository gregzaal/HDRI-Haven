<?php
$sort_options = ["popular" => "Downloads per day, with recent HDRIs weighted more",
                 "downloads" => "Total downloads over all time",
                 "date_published" => "When they were uploaded",
                 "date_taken" => "When they were original photgraphed"];
$current_url = $_SERVER['PHP_SELF'];
?>

<div class="grid-option-wrapper">
    <div class="grid-option">
        <span title="<?php echo $sort_options[$sort] ?>">
        <i class="material-icons sort-arrow">keyboard_arrow_down</i>
        <?php echo"Sort by: <b>".nice_name($sort)."</b>"; ?>
        </span>
        <div class="dropdown">
            <?php
            foreach (array_keys($sort_options) as $o) {
                echo "<a href='{$current_url}?c={$category}&amp;o={$o}&amp;s={$search}' ";
                echo "title=\"".$sort_options[$o]."\">";
                echo '<div class="dropdown-item">';
                if ($sort == $o) {
                    echo "<b>".nice_name($o)."</b>";
                }else{
                    echo nice_name($o);
                }
                echo "</div>";
                echo "</a>";
            }
            ?>
        </div>
    </div>

    <div class="grid-option search-box">
        <form action="/hdris/category" method="GET" class="search-form">
            <button class="search"><i class="material-icons">search</i></button>

            <?php
            // Include existing/default URL params
            echo '<input type="hidden" name="o" value="'.$sort.'" />';
            echo '<input type="hidden" name="c" value="'.$category.'" />';

            $search_box_text = "Search...";
            $classes = "search";
            if ($search != "all"){
                $search_box_text = $search;
                $classes .= " search-active";
            }
            echo '<input type="text" name="s" class="'.$classes.'" onClick="this.select();" value="'.$search_box_text.'" maxlength=100 />';
            ?>
        <?php
        if ($search != 'all') {
            echo "<a href='{$current_url}?o={$sort}&amp;c={$category}'>";
            echo '<i class="material-icons search-reset">close</i>';
            echo '</a>';
        }
        ?>
        </form>
    </div>
</div>
