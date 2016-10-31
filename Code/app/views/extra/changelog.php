<?php

/*

READ FIRST
-------------
-TO REMOVE NEW, UPDATED, FIXED OR REMOVED SECTION FROM A VERSION SIMPLY DELETE THE ARRAY OR ITS CONTENTS
-PUT NEWEST VERSIONS FIRST IN ARRAY

*/

$changeLogArray = array(
    array(
        "versionCode" => "01.51.20",
        "versionNumber" => 2, // should be a simple integer digit
        "date" => "6th October 2018", // use a consistent dating method
        "NEW" => array(
            "New Feature 23231",
            "New Feature 222"
        ),
        "UPDATED" => array(
            "NEW UPDATE"
        ),
        "FIXED" => array(
            "All bugs fixed"
        ),
        "REMOVED" => array(
            "You guess what features have been removed"
        )
    ),
    
    array(
        "versionCode" => "01.00.00",
        "versionNumber" => 1, // should be a simple integer digit
        "date" => "4th July 2016", // use a consistent dating method
        "NEW" => array(
            "New Feature 1",
            "New Feature 2"
        ),
        "UPDATED" => array(
            "New Update 1",
            "New Update 2",
            "NEW NEW UPDATE"
        ),
        "FIXED" => array(
            "About time it got fixed"
        ),
        "REMOVED" => array(
            "Finally that piece of shit is removed"
        )
    )
);

?>

<div>
    <h1>Release Notes and Version History</h1>
    
    <h2>aa.bc.de</h5>

    <p>aa - major website redesign or many changes since previous version</p>
    <p>b - major feature addition such as questions</p>
    <p>c - minor feature addition such as the ability to select a video in questions</p>
    <p>d - major bug fix</p>
    <p>e - minor bug fix</p>

    <h2>Change Type</h5>

    <p>[NEW] - new feature added</p>
    <p>[UPDATED] - feature updated</p>
    <p>[FIXED] - bug fixed</p>
    <p>[REMOVED] - feature removed</p>
    
<?php

foreach ( $changeLogArray as $change )
{
    
?>
    
    <h3><?= $change["versionCode"]; ?> (Version <?= $change["versionNumber"]; ?>) - <?= $change["date"]; ?></h3>
    
    <ul>
<?php
    if ( isset( $change["NEW"] ) )
    {
        foreach ( $change["NEW"] as $value )
        {
?>
            <li>[NEW] - <?= $value; ?></li>
<?php
        }
    }
?>
    </ul>
    
    <ul>
<?php
    if ( isset( $change["UPDATED"] ) )
    {
        foreach ( $change["UPDATED"] as $value )
        {
?>
            <li>[UPDATED] - <?= $value; ?></li>
<?php
        }
    }
?>
    </ul>
    
    <ul>
<?php
    if ( isset( $change["FIXED"] ) )
    {
        foreach ( $change["FIXED"] as $value )
        {
?>
            <li>[FIXED] - <?= $value; ?></li>
<?php
        }
    }
?>
    </ul>
    
    <ul>
<?php
    if ( isset( $change["REMOVED"] ) )
    {
        foreach ( $change["REMOVED"] as $value )
        {
?>
            <li>[REMOVED] - <?= $value; ?></li>
<?php
        }
    }
?>
    </ul>
    
<?php
    
}
    
?>
</div>