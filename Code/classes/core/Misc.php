<?php

/*
*   should be used for functions that are to be used from multiple classes
*   and have no obvious home :()
*/

namespace Sonar;

class Misc
{
    // Change website title that appears in the tab
    public static function ChangeWebsiteTitle( $title )
    {
        echo "  <script type='text/javascript'>
                    document.title = '$title';
                </script>";
    }
    
    // Generate a single Lorem Ipsum paragraph
    public static function GenerateLoremIpsumShortText( )
    {
        return "
        Lorem ipsum dolor sit amet, cu eos propriae incorrupte, sed vidit impetus probatus eu, ad illud partem sententiae vix. Ut vis inani persius. Ut qui nostrud utroque dissentiet, ex eum munere vivendo. Vix te quando quodsi, malorum suscipit vivendum mei ad. Amet omnis appareat vix ex. Cu vidit idque feugait has, modus mentitum eos cu.
        ";
    }
    
    // Generate a long Lorem Ipsum passage
    public static function GenerateLoremIpsumLongText( )
    {
        return "
        Lorem ipsum dolor sit amet, cu eos propriae incorrupte, sed vidit impetus probatus eu, ad illud partem sententiae vix. Ut vis inani persius. Ut qui nostrud utroque dissentiet, ex eum munere vivendo. Vix te quando quodsi, malorum suscipit vivendum mei ad. Amet omnis appareat vix ex. Cu vidit idque feugait has, modus mentitum eos cu.<br /><br />

        Vel altera virtute expetenda ne, tation torquatos no nam. Iriure constituto moderatius pri id. Eu pri graece saperet theophrastus, has cu dolores invidunt pertinacia, veritus ullamcorper ea qui. Vim dicant audire assueverit ad, at ius labore aliquip prompta, id eum aeque fuisset facilisi. Duo elitr saepe expetenda et, eum ocurreret explicari eu.<br /><br />

        Usu ipsum error officiis ea, nec at senserit petentium. Vis ipsum nonumes no. Quidam oblique ex cum. Omnium ancillae elaboraret ad nam, ea vis commune dignissim. Id vim enim doctus consulatu, te cum quis qualisque eloquentiam.<br /><br />

        Te nec maiorum albucius. Id eos possim saperet, mel nominavi deterruisset ad. Quo cu persequeris efficiantur accommodare, cu tritani similique pro, movet scripserit deterruisset vix in. In idque fastidii vis. Diceret suscipit atomorum ad qui, id aliquid deterruisset cum, mea illum principes ne.<br /><br />

        Magna consequuntur id quo, aeterno prompta in vix, solum reque sanctus at vel. Libris vocibus philosophia his at, qui at ferri adipisci. Eos consul volumus percipitur te, integre insolens quaestio id mel. Nam partem eruditi id, mea harum insolens no, cu est elitr probatus indoctum.
        ";
    }
    
    public static function Copyright( $year = NULL )
    {
        if ( NULL === $year )
        {
            $year = date( "Y" );
        }
        
        $companyName = Config::Get( "website/companyName" );
        
        return "Copyright &copy; $year $companyName";
    }
}