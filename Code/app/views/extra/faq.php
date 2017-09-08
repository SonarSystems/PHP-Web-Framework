<?php

Sonar\Misc::ChangeWebsiteTitle( "FAQ (Frequently Asked Questions)" );

/*

READ FIRST
-------------
-TO REMOVE A SECTION SIMPLY DELETE THE ARRAY OR ITS CONTENTS

*/

$faqArray = array(
        "Top Level 1" => array(
            "Sub Level 1" => "Content for Sub Level 1",
            "Sub Level 2" => "Content for Sub Level 2",
        ),
        
        "Top Level 2" => array(
            "Sub Level 3" => "Content for Sub Level 3",
            "Sub Level 4" => "Content for Sub Level 4",
            "Sub Level 5" => "Content for Sub Level 5",
            "Sub Level 6" => "Content for Sub Level 6",
        ),
);

?>

<div>
    <h1>FAQ (Frequently Asked Questions)</h1>
    
    <ul>
<?php
    
foreach ( $faqArray as $key => $question )
{
?>
        <li>
            <?= $key; ?>
<?php
    
    foreach ( $question as $key => $answer )
    {
?>
            <ul>
                <li>
                    <?= $key; ?>
                    
                    <ul>
                        <li><?= $answer; ?></li>
                    </ul>
                </li>
            </ul>
<?php
    }
}
    
?>
        </li>
    </ul>
</div>