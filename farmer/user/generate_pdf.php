<?php
require_once('./../../config.php');
require './../../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

if (isset($_POST['id'])) {
  $user = $conn->query("SELECT * FROM users WHERE id = " . $_POST['id'])->fetch_assoc();

  if ($user) {
    $basePath = 'http://' . $_SERVER['HTTP_HOST'] . '/agri-farm/libs/target001.png'; // Ensure this URL is accessible

    // Enable remote file access
    $options = $dompdf->getOptions();
    $options->set('isRemoteEnabled', true);
    $dompdf->setOptions($options);
    $customWidth = 800; // Set your desired width
    $customHeight = 2000; // Set your desired height
    // Load the HTML content into dompdf
    $html = '
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="" xml:lang="">
  <head>
    <title></title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <br />
    <style type="text/css">
      p {
        margin: 0;
        padding: 0;
      }
      .ft10 {
        font-size: 20px;
        font-family: Times;
        color: #000000;
      }
      .ft11 {
        font-size: 16px;
        font-family: Times;
        color: #000000;
      }
      .ft12 {
        font-size: 20px;
        font-family: Times;
        color: #000000;
      }
      .ft13 {
        font-size: 16px;
        font-family: Times;
        color: #000000;
      }
      .ft14 {
        font-size: 14px;
        font-family: Times;
        color: #000000;
      }
      .ft15 {
        font-size: 12px;
        font-family: Times;
        color: #000000;
      }
      .ft16 {
        font-size: 16px;
        font-family: Times;
        color: #000000;
      }
      .ft17 {
        font-size: 14px;
        font-family: Times;
        color: #000000;
      }
      .ft18 {
        font-size: 10px;
        font-family: Times;
        color: #000000;
      }
      .ft19 {
        font-size: 10px;
        font-family: Times;
        color: #000000;
      }
      .ft110 {
        font-size: 10px;
        font-family: Times;
        color: #000000;
      }
      .ft111 {
        font-size: 12px;
        font-family: Times;
        color: #000000;
      }
      .ft112 {
        font-size: 11px;
        font-family: Times;
        color: #000000;
      }
      .ft113 {
        font-size: 7px;
        font-family: Times;
        color: #000000;
      }
      .ft114 {
        font-size: 12px;
        font-family: Times;
        color: #000000;
      }
      .ft115 {
        font-size: 12px;
        font-family: Times;
        color: #000000;
      }
      .ft116 {
        font-size: 16px;
        line-height: 30px;
        font-family: Times;
        color: #000000;
      }
      .ft117 {
        font-size: 10px;
        line-height: 14px;
        font-family: Times;
        color: #000000;
      }
      .ft118 {
        font-size: 10px;
        line-height: 16px;
        font-family: Times;
        color: #000000;
      }
      .ft119 {
        font-size: 11px;
        line-height: 18px;
        font-family: Times;
        color: #000000;
      }
      .ft120 {
        font-size: 11px;
        line-height: 15px;
        font-family: Times;
        color: #000000;
      }
      .ft121 {
        font-size: 14px;
        line-height: 19px;
        font-family: Times;
        color: #000000;
      }
      .ft122 {
        font-size: 16px;
        line-height: 16px;
        font-family: Times;
        color: #000000;
      }
          body {
            margin: 0;
            padding: 0;
        }
          #page1-div {
            width: 595px; /* A4 width */
            height: 842px; /* A4 height */
        }
        img {
            width: 595px; /* Fit image to A4 width */
            height: auto; /* Maintain aspect ratio */
        }
    </style>
  </head>
  <body >
    <div
      id="page1-div"
      
    >
       <img src="' . $basePath . '" alt="background image" />

      <p
        style="position: absolute; top: 128px; left: 170px; white-space: nowrap"
        class="ft10"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 68px; left: 254px; white-space: nowrap"
        class="ft11"
      >
        Bureau of&#160;Plant&#160;Industry
      </p>
      <p
        style="position: absolute; top: 63px; left: 443px; white-space: nowrap"
        class="ft12"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 89px; left: 191px; white-space: nowrap"
        class="ft13"
      >
        <b>Plant&#160;Product&#160;Safety Services Division&#160;</b>
      </p>
      <p
        style="position: absolute; top: 110px; left: 228px; white-space: nowrap"
        class="ft13"
      >
        <b>PhilGAP&#160;APPLICATION FORM&#160;</b>
      </p>
      <p
        style="position: absolute; top: 58px; left: 526px; white-space: nowrap"
        class="ft116"
      >
        <b>Document&#160;No.:&#160;</b>BPI-QMS-PPSSD-F1<b
          >&#160;<br />Effectivity Date:&#160;</b
        >August 10,&#160;2021<b>&#160;<br />Revision No.:</b>&#160;0&#160;
      </p>
      <p
        style="position: absolute; top: 120px; left: 737px; white-space: nowrap"
        class="ft14"
      >
        Page&#160;1&#160;of&#160;1&#160;
      </p>
      <p
        style="position: absolute; top: 145px; left: 54px; white-space: nowrap"
        class="ft11"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 145px; left: 643px; white-space: nowrap"
        class="ft11"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 167px; left: 59px; white-space: nowrap"
        class="ft15"
      >
        <i
          >Complete all&#160;information&#160;below.&#160;Indicate&#160;N/A
          if&#160;not&#160;applicable.</i
        >
      </p>
      <p
        style="position: absolute; top: 164px; left: 449px; white-space: nowrap"
        class="ft16"
      >
        <i>&#160;</i>
      </p>
      <p
        style="position: absolute; top: 189px; left: 59px; white-space: nowrap"
        class="ft17"
      >
        <b>1.&#160;TYPE&#160;OF&#160;APPLICATION&#160;</b>
      </p>
      <p
        style="position: absolute; top: 186px; left: 292px; white-space: nowrap"
        class="ft11"
      >
        &#160; &#160; &#160;&#160;
      </p>
      <p
        style="position: absolute; top: 187px; left: 316px; white-space: nowrap"
        class="ft14"
      >
        New&#160; &#160;
        &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;Renewal,&#160;PhilGAP&#160;certificate
        number:&#160;<b>BPI-&#160;__&#160;__&#160;__&#160;-&#160;__&#160;__</b>
      </p>
      <p
        style="position: absolute; top: 186px; left: 783px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 212px; left: 59px; white-space: nowrap"
        class="ft17"
      >
        <b>2.&#160;FARM&#160;NAME&#160;</b>
      </p>
      <p
        style="position: absolute; top: 231px; left: 59px; white-space: nowrap"
        class="ft117"
      >
        <i
          >Farm&#160;name&#160;will&#160;appear&#160;on&#160;the&#160;PhilGAP&#160;<br />Certificate.</i
        ><b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 212px; left: 292px; white-space: nowrap"
        class="ft11"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 260px; left: 59px; white-space: nowrap"
        class="ft17"
      >
        <b>3.&#160;APPLICANT’S&#160;NAME&#160;</b>
      </p>
      <p
        style="position: absolute; top: 279px; left: 59px; white-space: nowrap"
        class="ft117"
      >
        <i
          >Name&#160;of&#160;owner&#160;or&#160;authorized&#160;representative&#160;<br />of&#160;the&#160;farm&#160;or&#160;company.</i
        >
      </p>
      <p
        style="position: absolute; top: 289px; left: 178px; white-space: nowrap"
        class="ft17"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 260px; left: 292px; white-space: nowrap"
        class="ft14"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 314px; left: 59px; white-space: nowrap"
        class="ft17"
      >
        <b>4.&#160;CONTACT INFORMATION&#160;</b>
      </p>
      <p
        style="position: absolute; top: 314px; left: 292px; white-space: nowrap"
        class="ft14"
      >
        Mobile no.:&#160; &#160; &#160; &#160; &#160;&#160; &#160;
        &#160;&#160;&#160; &#160; &#160;&#160; &#160; &#160;&#160;
        &#160;&#160;&#160; &#160; &#160; &#160;&#160; &#160;
        &#160;&#160;&#160;&#160;Email Add.:&#160;
      </p>
      <p
        style="position: absolute; top: 339px; left: 59px; white-space: nowrap"
        class="ft17"
      >
        <b>5.&#160;FARM&#160;SIZE&#160;AND&#160;ADDRESS</b>
      </p>
      <p
        style="position: absolute; top: 343px; left: 270px; white-space: nowrap"
        class="ft18"
      >
        <i>&#160;(use&#160;additional&#160;sheet if&#160;necessary)&#160;</i>
      </p>
      <p
        style="position: absolute; top: 358px; left: 59px; white-space: nowrap"
        class="ft18"
      >
        <i
          >&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;Hectarage&#160;&#160;&#160;</i
        >
      </p>
      <p
        style="position: absolute; top: 352px; left: 169px; white-space: nowrap"
        class="ft11"
      >
        &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160;&#160;&#160;
      </p>
      <p
        style="position: absolute; top: 358px; left: 237px; white-space: nowrap"
        class="ft18"
      >
        <i
          >Street&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;Barangay&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;City/Municipality&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;Province</i
        >
      </p>
      <p
        style="position: absolute; top: 352px; left: 764px; white-space: nowrap"
        class="ft11"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 373px; left: 59px; white-space: nowrap"
        class="ft18"
      >
        <i>Farm&#160;1:&#160;</i>
      </p>
      <p
        style="position: absolute; top: 387px; left: 59px; white-space: nowrap"
        class="ft118"
      >
        &#160;<br /><i>Farm&#160;2:&#160;</i>
      </p>
      <p
        style="position: absolute; top: 434px; left: 59px; white-space: nowrap"
        class="ft18"
      >
        <i>Farm&#160;3:&#160;</i>
      </p>
      <p
        style="position: absolute; top: 465px; left: 59px; white-space: nowrap"
        class="ft17"
      >
        <b>6.</b>&#160;<b
          >CROPS&#160;APPLIED&#160;FOR&#160;PhilGAP&#160;CERTIFICATION&#160;</b
        >
      </p>
      <p
        style="position: absolute; top: 484px; left: 59px; white-space: nowrap"
        class="ft18"
      >
        <i
          >*Approximate&#160;quantity&#160;harvested per&#160;year&#160;must
          be&#160;expressed in&#160;amount&#160;of&#160;produced per&#160;unit
          of&#160;the&#160;area&#160;planted (use&#160;additional&#160;sheet
          if&#160;necessary).&#160;</i
        >
      </p>
      <p
        style="position: absolute; top: 506px; left: 114px; white-space: nowrap"
        class="ft17"
      >
        <b>CROP&#160;</b>
      </p>
      <p
        style="position: absolute; top: 506px; left: 266px; white-space: nowrap"
        class="ft17"
      >
        <b>VARIETY&#160;</b>
      </p>
      <p
        style="position: absolute; top: 506px; left: 403px; white-space: nowrap"
        class="ft17"
      >
        <b>HECTARAGE&#160;</b>
      </p>
      <p
        style="position: absolute; top: 506px; left: 537px; white-space: nowrap"
        class="ft17"
      >
        <b>HARVEST*&#160;</b>
      </p>
      <p
        style="position: absolute; top: 499px; left: 705px; white-space: nowrap"
        class="ft17"
      >
        <b>PURPOSE&#160;</b>
      </p>
      <p
        style="position: absolute; top: 518px; left: 686px; white-space: nowrap"
        class="ft18"
      >
        <i>(e.g.&#160;for&#160;food,&#160;for&#160;feed)</i>&#160;
      </p>
      <p
        style="position: absolute; top: 533px; left: 60px; white-space: nowrap"
        class="ft18"
      >
        <i>1.&#160;</i>
      </p>
      <p
        style="position: absolute; top: 533px; left: 87px; white-space: nowrap"
        class="ft18"
      >
        <i>&#160;</i>
      </p>
      <p
        style="position: absolute; top: 533px; left: 215px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 533px; left: 388px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 533px; left: 516px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 533px; left: 643px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 563px; left: 60px; white-space: nowrap"
        class="ft18"
      >
        <i>2.&#160;</i>
      </p>
      <p
        style="position: absolute; top: 563px; left: 87px; white-space: nowrap"
        class="ft18"
      >
        <i>&#160;</i>
      </p>
      <p
        style="position: absolute; top: 563px; left: 215px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 563px; left: 388px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 563px; left: 516px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 563px; left: 643px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 594px; left: 60px; white-space: nowrap"
        class="ft18"
      >
        <i>3.&#160;</i>
      </p>
      <p
        style="position: absolute; top: 594px; left: 87px; white-space: nowrap"
        class="ft18"
      >
        <i>&#160;</i>
      </p>
      <p
        style="position: absolute; top: 594px; left: 215px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 594px; left: 388px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 594px; left: 516px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 594px; left: 643px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 624px; left: 60px; white-space: nowrap"
        class="ft18"
      >
        <i>4.&#160;</i>
      </p>
      <p
        style="position: absolute; top: 624px; left: 87px; white-space: nowrap"
        class="ft18"
      >
        <i>&#160;</i>
      </p>
      <p
        style="position: absolute; top: 624px; left: 215px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 624px; left: 388px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 624px; left: 516px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 624px; left: 643px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 655px; left: 60px; white-space: nowrap"
        class="ft18"
      >
        <i>5.&#160;</i>
      </p>
      <p
        style="position: absolute; top: 655px; left: 87px; white-space: nowrap"
        class="ft18"
      >
        <i>&#160;</i>
      </p>
      <p
        style="position: absolute; top: 655px; left: 215px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 655px; left: 388px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 655px; left: 516px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 655px; left: 643px; white-space: nowrap"
        class="ft13"
      >
        <b>&#160;</b>
      </p>
      <p
        style="position: absolute; top: 686px; left: 59px; white-space: nowrap"
        class="ft111"
      >
        <b>Required&#160;Documents&#160;</b>
      </p>
      <p
        style="position: absolute; top: 688px; left: 207px; white-space: nowrap"
        class="ft110"
      >
        (<i>incomplete&#160;application&#160;will&#160;not&#160;be&#160;accepted</i>)<b
          >&#160;</b
        >
      </p>
      <p
        style="position: absolute; top: 706px; left: 86px; white-space: nowrap"
        class="ft120"
      >
        Farm&#160;or&#160;organizational&#160;profile;&#160;<br />Farm&#160;map;&#160;<br />Farm&#160;Layout&#160;<br />Field&#160;operation&#160;procedures&#160;<br />Production&#160;and&#160;Harvesting&#160;Records&#160;
      </p>
      <p
        style="position: absolute; top: 776px; left: 294px; white-space: nowrap"
        class="ft113"
      >
        (Annex&#160;A)&#160;
      </p>
      <p
        style="position: absolute; top: 787px; left: 86px; white-space: nowrap"
        class="ft112"
      >
        List&#160;of&#160;farm&#160;inputs&#160;
      </p>
      <p
        style="position: absolute; top: 791px; left: 194px; white-space: nowrap"
        class="ft113"
      >
        (Annex&#160;B)
      </p>
      <p
        style="position: absolute; top: 787px; left: 233px; white-space: nowrap"
        class="ft112"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 803px; left: 86px; white-space: nowrap"
        class="ft120"
      >
        Certificate&#160;of&#160;Nutrient&#160;Soil&#160;Analysis&#160;<br />Certificate&#160;of&#160;training&#160;on&#160;GAP&#160;conducted&#160;by&#160;ATI,&#160;BPI,&#160;LGU,&#160;DA&#160;<br />RFO,&#160;SUCs&#160;or&#160;by&#160;ATI&#160;accredited&#160;service&#160;providers.&#160;
      </p>
      <p
        style="position: absolute; top: 850px; left: 86px; white-space: nowrap"
        class="ft120"
      >
        Certificate&#160;&#160;of&#160;&#160;Registration&#160;&#160;and&#160;&#160;other&#160;&#160;related&#160;&#160;permits,&#160;&#160;e.g.&#160;<br />RSBSA,&#160;SEC,&#160;DTI,&#160;CDA&#160;(as&#160;applicable)
      </p>
      <p
        style="position: absolute; top: 865px; left: 298px; white-space: nowrap"
        class="ft114"
      >
        <i><b>&#160; &#160; &#160;&#160;&#160;</b></i>
      </p>
      <p
        style="position: absolute; top: 686px; left: 462px; white-space: nowrap"
        class="ft111"
      >
        <b>Additional&#160;Documents&#160;for&#160;Group&#160;Application</b
        >&#160;
      </p>
      <p
        style="position: absolute; top: 706px; left: 490px; white-space: nowrap"
        class="ft120"
      >
        Quality&#160;Management&#160;System/Internal&#160;Control&#160;System&#160;&#160;or&#160;<br />equivalent&#160;<br />Procedure&#160;for&#160;accreditation&#160;of&#160;farmers/growers&#160;<br />Manual&#160;&#160;of&#160;&#160;Procedure&#160;&#160;for&#160;&#160;outgrowership&#160;&#160;scheme&#160;&#160;which&#160;<br />will&#160;&#160;show&#160;&#160;that&#160;&#160;the&#160;&#160;group&#160;&#160;have&#160;&#160;100%&#160;&#160;control&#160;&#160;of&#160;&#160;all&#160;<br />registered&#160;or&#160;accredited&#160;growers&#160;(e.g.&#160;internal&#160;policies&#160;on&#160;
      </p>
      <p
        style="position: absolute; top: 801px; left: 490px; white-space: nowrap"
        class="ft120"
      >
        accreditation&#160;of&#160;farmer/grower,&#160;sanctions,&#160;etc.)&#160;<br />&#160;
      </p>
      <p
        style="position: absolute; top: 832px; left: 490px; white-space: nowrap"
        class="ft115"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 892px; left: 54px; white-space: nowrap"
        class="ft11"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 909px; left: 124px; white-space: nowrap"
        class="ft14"
      >
        The&#160;farm&#160;management&#160;is&#160;committed&#160;to&#160;good&#160;farming&#160;practices&#160;and&#160;to&#160;the&#160;safety&#160;of&#160;its&#160;produce&#160;for&#160;
      </p>
      <p
        style="position: absolute; top: 929px; left: 67px; white-space: nowrap"
        class="ft14"
      >
        supply&#160;to&#160;consumers,&#160;and&#160;in&#160;maintaining&#160;a&#160;high&#160;standard&#160;of&#160;quality&#160;in&#160;its&#160;production.&#160;All&#160;measures&#160;were&#160;taken&#160;
      </p>
      <p
        style="position: absolute; top: 948px; left: 67px; white-space: nowrap"
        class="ft121"
      >
        to&#160;fully&#160;implement&#160;the&#160;farm&#160;in&#160;Philippine&#160;Good&#160;Agricultural&#160;Practices&#160;(PhilGAP)&#160;program.&#160;I&#160;hereby&#160;support&#160;to&#160;<br />adopting&#160;and&#160;implementing&#160;the&#160;PhilGAP&#160;standards.&#160;
      </p>
      <p
        style="position: absolute; top: 987px; left: 124px; white-space: nowrap"
        class="ft121"
      >
        &#160;<br />I&#160;&#160;hereby&#160;&#160;consent&#160;&#160;to&#160;&#160;all&#160;&#160;the&#160;&#160;requirements&#160;&#160;as&#160;&#160;needed&#160;&#160;by&#160;&#160;the&#160;&#160;inspection&#160;&#160;body.&#160;&#160;All&#160;&#160;information&#160;&#160;shall&#160;
      </p>
      <p
        style="position: absolute; top: 1025px; left: 67px; white-space: nowrap"
        class="ft121"
      >
        remain&#160;confidential&#160;at&#160;all&#160;times,&#160;unless&#160;prohibited&#160;by&#160;law.&#160;The&#160;information&#160;above&#160;and&#160;those&#160;that&#160;are&#160;seen&#160;in&#160;<br />the
        succeeding&#160;attachments&#160;are&#160;hereby&#160;certified&#160;true
        and&#160;correct.&#160;
      </p>
      <p
        style="position: absolute; top: 1064px; left: 59px; white-space: nowrap"
        class="ft121"
      >
        &#160;<br />&#160; &#160;
        &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;______________________________________________&#160;
        &#160; &#160; &#160;&#160;&#160; &#160; &#160; &#160;&#160; &#160;
        &#160;&#160;&#160; &#160; &#160;&#160; &#160; &#160;&#160; &#160;
        &#160;&#160;&#160; &#160;
        &#160;&#160;____________________________________&#160;
      </p>
      <p
        style="position: absolute; top: 1103px; left: 67px; white-space: nowrap"
        class="ft14"
      >
        &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
        &#160;&#160;Signature above
        printed&#160;name&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
        &#160;Date
      </p>
      <p
        style="
          position: absolute;
          top: 1106px;
          left: 681px;
          white-space: nowrap;
        "
        class="ft112"
      >
        &#160;&#160;
      </p>
      <p
        style="
          position: absolute;
          top: 1123px;
          left: 228px;
          white-space: nowrap;
        "
        class="ft18"
      >
        <i
          >All&#160;information&#160;provided will&#160;be&#160;managed
          in&#160;accordance&#160;with&#160;the&#160;Data&#160;Privacy&#160;Act
          of&#160;2012.</i
        >
      </p>
      <p
        style="
          position: absolute;
          top: 1120px;
          left: 680px;
          white-space: nowrap;
        "
        class="ft115"
      >
        &#160;
      </p>
      <p
        style="
          position: absolute;
          top: 1138px;
          left: 454px;
          white-space: nowrap;
        "
        class="ft18"
      >
        <i>&#160;</i>
      </p>
      <p
        style="position: absolute; top: 1153px; left: 54px; white-space: nowrap"
        class="ft11"
      >
        &#160;
      </p>
      <p
        style="
          position: absolute;
          top: 1153px;
          left: 784px;
          white-space: nowrap;
        "
        class="ft11"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 1174px; left: 54px; white-space: nowrap"
        class="ft11"
      >
        &#160;
      </p>
      <p
        style="
          position: absolute;
          top: 1174px;
          left: 784px;
          white-space: nowrap;
        "
        class="ft11"
      >
        &#160;
      </p>
      <p
        style="position: absolute; top: 716px; left: 476px; white-space: nowrap"
        class="ft11"
      >
        &#160;&#160;
      </p>
      <p
        style="position: absolute; top: 745px; left: 476px; white-space: nowrap"
        class="ft11"
      >
        &#160;&#160;
      </p>
      <p
        style="position: absolute; top: 761px; left: 476px; white-space: nowrap"
        class="ft11"
      >
        &#160;&#160;
      </p>
      <p
        style="position: absolute; top: 717px; left: 71px; white-space: nowrap"
        class="ft11"
      >
        &#160;&#160;
      </p>
      <p
        style="position: absolute; top: 733px; left: 71px; white-space: nowrap"
        class="ft122"
      >
        &#160;&#160;<br />&#160;&#160;<br />&#160;&#160;<br />&#160;&#160;
      </p>
      <p
        style="position: absolute; top: 797px; left: 71px; white-space: nowrap"
        class="ft11"
      >
        &#160;&#160;
      </p>
      <p
        style="position: absolute; top: 813px; left: 71px; white-space: nowrap"
        class="ft11"
      >
        &#160;&#160;
      </p>
      <p
        style="position: absolute; top: 862px; left: 71px; white-space: nowrap"
        class="ft11"
      >
        &#160;&#160;
      </p>
      <p
        style="position: absolute; top: 829px; left: 71px; white-space: nowrap"
        class="ft11"
      >
        &#160;&#160;
      </p>
    </div>
  </body>
</html>

';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('farmer_details.pdf', ['Attachment' => true]);


    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('farmer_details.pdf', ['Attachment' => true]);
  } else {
    echo "No user found with this ID.";
  }
} else {
  echo "Invalid request. No user ID provided.";
}
