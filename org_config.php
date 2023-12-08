<?php
include("classes/autoloader.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stud_ID = $_POST['stud_ID'];
    $orgs = ['BISU', 'CSO', 'SCV', 'ICPEP', 'CEA', 'SSG', 'MAYORS_LEAGUE', 'LUDAFIL', 'YMMA', 'PICE_ACES', 'SEES_IIEE_SC', 'UAPSA', 
            'BIDA', 'JPSME', 'ADA', 'ATTS', 'EESA', 'LATEST', 'MATH_ISIP', 'OASIS', 'SCUBAP', 'SPE', 'YES', 'AHWB', 'BISU_CHORALE', 
            'GDSC', 'HSC', 'KGEN', 'PFC', 'SKILARTALES', 'TAWUSO', 'VAG', 'DOST_SA_BOHOL', 'RCY', 'IVCF', 'KKBM', 'SFC', 'SMCI', 
            'YFCCB', 'JESUS_AND_ME', 'ASUL', 'BDATS', 'ALLY', 'ABCD', 'ANDA', 'ALSO', 'BISUs_PILAR', 'BISUbayanons', 'BTAP', 'BTAP_3', 
            'BUGS', 'CYou', 'COOL', 'CSA', 'DANAO_SCOUT', 'ABDUCT', 'HCB', 'JUST', 'LOLs', 'MABINIANS', 'MYLS', 'SICAD', 'SIDLAK', 'SISS',
             'SMART', 'SMTEP', 'SOLID', 'SQUAD', 'SYC', 'GO_TCC', 'TEGUM', 'TRIAD', 'UBSA_BISU', 'EG', 'USBBC', 'BVAULTS', 'USB', 'LLS', 'SIAW'];


    foreach ($orgs as $org) {
        $orgName = "org_" . $org;
        $showLogo = isset($_POST[$orgName]) ? 1 : 0;
        
        // Set logo_path and logo_url based on the selected organization
        switch ($org) {
            case 'BISU':
                $logoPath = 'images/org/BISU.jpg';
                $logoURL = 'https://www.facebook.com/bisuofficial';
                break;
            case 'CSO':
                $logoPath = 'images/org/cso.jpg';
                $logoURL = 'https://www.facebook.com/BISUMCCSO';
                break;
            case 'SCV':
                $logoPath = 'images/org/scv.jpg';
                $logoURL = 'https://www.facebook.com/bisumcSCV';
                break;
            case 'ICPEP':
                $logoPath = 'images/org/ICPEP.jpg';
                $logoURL = 'https://www.facebook.com/icpepsebisumc';
                break;
            case 'CEA':
                $logoPath = 'images/org/cea.jpg';
                $logoURL = 'https://www.facebook.com/cea.bisumain';
                break;
            case 'SSG':
                $logoPath = 'images/org/ssg.jpg';
                $logoURL = 'https://www.facebook.com/BISUMCSSG';
                break;
            case 'MAYORS_LEAGUE':
                $logoPath = 'images/org/mayors_league.jpg';
                $logoURL = '#';
                break;
            case 'LUDAFIL':
                $logoPath = 'images/org/ludafil.jpg';
                $logoURL = '#';
                break;
            case 'YMMA':
                $logoPath = 'images/org/ymma.jpg';
                $logoURL = '#';
                break;
            case 'PICE_ACES':
                $logoPath = 'images/org/pice_aces.jpg';
                $logoURL = '#';
                break;
            case 'SEES_IIEE_SC':
                $logoPath = 'images/org/sees_iiee_sc.jpg';
                $logoURL = '#';
                break;
            case 'UAPSA':
                $logoPath = 'images/org/uapsa.jpg';
                $logoURL = '#';
                break;
            case 'BIDA':
                $logoPath = 'images/org/bida.jpg';
                $logoURL = '#';
                break;
            case 'JPSME':
                $logoPath = 'images/org/jpsme.jpg';
                $logoURL = '#';
                break;
            case 'ADA':
                $logoPath = 'images/org/ada.jpg';
                $logoURL = '#';
                break;
            case 'ATTS':
                $logoPath = 'images/org/atts.jpg';
                $logoURL = '#';
                break;
            case 'EESA':
                $logoPath = 'images/org/eesa.jpg';
                $logoURL = '#';
                break;
            case 'LATEST':
                $logoPath = 'images/org/latest.jpg';
                $logoURL = '#';
                break;
            case 'MATH_ISIP':
                $logoPath = 'images/org/math_isip.jpg';
                $logoURL = '#';
                break;
            case 'OASIS':
                $logoPath = 'images/org/oasis.jpg';
                $logoURL = '#';
                break;
            case 'SCUBAP':
                $logoPath = 'images/org/scubap.jpg';
                $logoURL = '#';
                break;
            case 'SPE':
                $logoPath = 'images/org/spe.jpg';
                $logoURL = '#';
                break;
            case 'YES':
                $logoPath = 'images/org/yes.jpg';
                $logoURL = '#';
                break;
            case 'AHWB':
                $logoPath = 'images/org/ahwb.jpg';
                $logoURL = '#';
                break;
            case 'BISU_CHORALE':
                $logoPath = 'images/org/bisu_chorale.jpg';
                $logoURL = '#';
                break;
            case 'GDSC':
                $logoPath = 'images/org/gdsc.jpg';
                $logoURL = '#';
                break;
            case 'HSC':
                $logoPath = 'images/org/hsc.jpg';
                $logoURL = '#';
                break;
            case 'KGEN':
                $logoPath = 'images/org/kgen.jpg';
                $logoURL = '#';
                break;
            case 'PFC':
                $logoPath = 'images/org/pfc.jpg';
                $logoURL = '#';
                break;
            case 'SKILARTALES':
                $logoPath = 'images/org/skilartales.jpg';
                $logoURL = '#';
                break;
            case 'TAWUSO':
                $logoPath = 'images/org/tawuso.jpg';
                $logoURL = '#';
                break;
            case 'VAG':
                $logoPath = 'images/org/vag.jpg';
                $logoURL = '#';
                break;
            case 'DOST_SA_BOHOL':
                $logoPath = 'images/org/dost_sa_bohol.jpg';
                $logoURL = '#';
                break;
            case 'RCY':
                $logoPath = 'images/org/rcy.jpg';
                $logoURL = '#';
                break;
            case 'IVCF':
                $logoPath = 'images/org/ivcf.jpg';
                $logoURL = '#';
                break;
            case 'KKBM':
                $logoPath = 'images/org/kkbm.jpg';
                $logoURL = '#';
                break;
            case 'SFC':
                $logoPath = 'images/org/sfc.jpg';
                $logoURL = '#';
                break;
            case 'SMCI':
                $logoPath = 'images/org/smci.jpg';
                $logoURL = '#';
                break;
            case 'YFCCB':
                $logoPath = 'images/org/yfccb.jpg';
                $logoURL = '#';
                break;
            case 'JESUS_AND_ME':
                $logoPath = 'images/org/jesus_and_me.jpg';
                $logoURL = '#';
                break;
            case 'ASUL':
                $logoPath = 'images/org/asul.jpg';
                $logoURL = '#';
                break;
            case 'BDATS':
                $logoPath = 'images/org/bdats.jpg';
                $logoURL = 'https://www.facebook.com/bdats.bisumc';
                break;
            case 'ALLY':
                $logoPath = 'images/org/ally.jpg';
                $logoURL = '#';
                break;
            case 'ABCD':
                $logoPath = 'images/org/abcd.jpg';
                $logoURL = '#';
                break;
            case 'ANDA':
                $logoPath = 'images/org/anda.jpg';
                $logoURL = '#';
                break;
            case 'ALSO':
                $logoPath = 'images/org/also.jpg';
                $logoURL = '#';
                break;
            case 'BISUs_PILAR':
                $logoPath = 'images/org/bisus_pilar.jpg';
                $logoURL = '#';
                break;
            case 'BISUbayanons':
                $logoPath = 'images/org/bisubayanons.jpg';
                $logoURL = '#';
                break;
            case 'BTAP':
                $logoPath = 'images/org/btap.jpg';
                $logoURL = '#';
                break;
            case 'BTAP_3':
                $logoPath = 'images/org/btap_3.jpg';
                $logoURL = '#';
                break;
            case 'BUGS':
                $logoPath = 'images/org/bugs.jpg';
                $logoURL = '#';
                break;
            case 'CYou':
                $logoPath = 'images/org/cyou.jpg';
                $logoURL = '#';
                break;
            case 'COOL':
                $logoPath = 'images/org/cool.jpg';
                $logoURL = '#';
                break;
            case 'CSA':
                $logoPath = 'images/org/csa.jpg';
                $logoURL = '#';
                break;
            case 'DANAO_SCOUT':
                $logoPath = 'images/org/danao_scout.jpg';
                $logoURL = '#';
                break;
            case 'ABDUCT':
                $logoPath = 'images/org/abduct.jpg';
                $logoURL = '#';
                break;
            case 'HCB':
                $logoPath = 'images/org/hcb.jpg';
                $logoURL = '#';
                break;
            case 'JUST':
                $logoPath = 'images/org/just.jpg';
                $logoURL = '#';
                break;
            case 'LOLs':
                $logoPath = 'images/org/lols.jpg';
                $logoURL = '#';
                break;
            case 'MABINIANS':
                $logoPath = 'images/org/mabinians.jpg';
                $logoURL = '#';
                break;
            case 'MYLS':
                $logoPath = 'images/org/myls.jpg';
                $logoURL = '#';
                break;
            case 'SICAD':
                $logoPath = 'images/org/sicad.jpg';
                $logoURL = '#';
                break;
            case 'SIDLAK':
                $logoPath = 'images/org/sidlak.jpg';
                $logoURL = '#';
                break;
            case 'SISS':
                $logoPath = 'images/org/siss.jpg';
                $logoURL = '#';
                break;
            case 'SMART':
                $logoPath = 'images/org/smart.jpg';
                $logoURL = '#';
                break;
            case 'SMTEP':
                $logoPath = 'images/org/smtep.jpg';
                $logoURL = '#';
                break;
            case 'SOLID':
                $logoPath = 'images/org/solid.jpg';
                $logoURL = '#';
                break;
            case 'SQUAD':
                $logoPath = 'images/org/squad.jpg';
                $logoURL = '#';
                break;
            case 'SYC':
                $logoPath = 'images/org/syc.jpg';
                $logoURL = '#';
                break;
            case 'GO_TCC':
                $logoPath = 'images/org/go_tcc.jpg';
                $logoURL = '#';
                break;
            case 'TEGUM':
                $logoPath = 'images/org/tegum.jpg';
                $logoURL = '#';
                break;
            case 'TRIAD':
                $logoPath = 'images/org/triad.jpg';
                $logoURL = '#';
                break;
            case 'UBSA_BISU':
                $logoPath = 'images/org/ubsa_bisu.jpg';
                $logoURL = '#';
                break;
            case 'EG':
                $logoPath = 'images/org/eg.jpg';
                $logoURL = '#';
                break;
            case 'USBBC':
                $logoPath = 'images/org/usbbc.jpg';
                $logoURL = '#';
                break;
            case 'BVAULTS':
                $logoPath = 'images/org/bvaults.jpg';
                $logoURL = '#';
                break;
            case 'USB':
                $logoPath = 'images/org/usb.jpg';
                $logoURL = '#';
                break;
            case 'LLS':
                $logoPath = 'images/org/lls.jpg';
                $logoURL = '#';
                break;
            case 'SIAW':
                $logoPath = 'images/org/siaw.jpg';
                $logoURL = '#';
                break;


            // Add other cases as needed
            default:
                $logoPath = null;
                $logoURL = null;
                break;
        }

        // Update the database with the new configuration
        $query = "INSERT INTO org_config (stud_ID, org_name, show_logo, logo_path, logo_url)
                  VALUES ('$stud_ID', '$org', '$showLogo', '$logoPath', '$logoURL')
                  ON DUPLICATE KEY UPDATE show_logo = '$showLogo', logo_path = '$logoPath', logo_url = '$logoURL'";
        $DB = new CONNECTION_DB();
        $DB->save($query);
    }

    // Redirect back to the configuration page after updating
    header("Location: index.php");
    exit();
}
?>
