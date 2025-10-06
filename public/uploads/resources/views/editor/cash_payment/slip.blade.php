@extends('layouts.editor.template')
@section('title', 'Slip Pengeluaran Kas')  
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title"> Pengeluaran Kas</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Keuangan</a></li>
                  <li class="active">Pengeluaran Kas</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div> 
      <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box printableArea"> 

                  <html xmlns:o="urn:schemas-microsoft-com:office:office"
                  xmlns:x="urn:schemas-microsoft-com:office:excel"
                  xmlns="http://www.w3.org/TR/REC-html40">

                  <head>
                  <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
                  <meta name=ProgId content=Excel.Sheet>
                  <meta name=Generator content="Microsoft Excel 15">
                  <link rel=File-List href="Slip%20Cash%20Payment_files/filelist.xml">
                  <style id="Slip Cash Payment_18456_Styles"><!--table
                    {mso-displayed-decimal-separator:"\,";
                    mso-displayed-thousand-separator:"\,";}
                  .xl6318456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:Calibri, sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:general;
                    vertical-align:bottom;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl6418456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:13.0pt;
                    font-weight:700;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl6518456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:general;
                    vertical-align:bottom;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl6618456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:700;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:middle;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl6718456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:general;
                    vertical-align:middle;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl6818456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:left;
                    vertical-align:middle;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl6918456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:Calibri, sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:general;
                    vertical-align:middle;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl7018456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:left;
                    vertical-align:bottom;
                    border-top:none;
                    border-right:none;
                    border-bottom:.5pt solid windowtext;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl7118456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:700;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border:.5pt solid windowtext;
                    background:#F2F2F2;
                    mso-pattern:black none;
                    white-space:normal;}
                  .xl7218456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:left;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:none;
                    border-bottom:.5pt solid windowtext;
                    border-left:.5pt solid windowtext;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl7318456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:left;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:none;
                    border-bottom:.5pt solid windowtext;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl7418456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:left;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:.5pt solid windowtext;
                    border-bottom:.5pt solid windowtext;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl7518456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:right;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:none;
                    border-bottom:.5pt solid windowtext;
                    border-left:.5pt solid windowtext;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl7618456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:right;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:none;
                    border-bottom:.5pt solid windowtext;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl7718456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:right;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:.5pt solid windowtext;
                    border-bottom:.5pt solid windowtext;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl7818456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:700;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:right;
                    vertical-align:bottom;
                    border:.5pt solid windowtext;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl7918456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:700;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl8018456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:none;
                    border-bottom:.5pt solid windowtext;
                    border-left:.5pt solid windowtext;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl8118456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:none;
                    border-bottom:.5pt solid windowtext;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl8218456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:.5pt solid windowtext;
                    border-bottom:.5pt solid windowtext;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl8318456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:700;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border:.5pt solid windowtext;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl8418456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:general;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:none;
                    border-bottom:none;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl8518456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border:.5pt solid windowtext;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl8618456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:none;
                    border-bottom:none;
                    border-left:.5pt solid windowtext;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl8718456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:.5pt solid windowtext;
                    border-bottom:none;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl8818456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:.5pt solid windowtext;
                    border-right:none;
                    border-bottom:none;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl8918456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:none;
                    border-right:none;
                    border-bottom:none;
                    border-left:.5pt solid windowtext;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl9018456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:none;
                    border-right:.5pt solid windowtext;
                    border-bottom:none;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl9118456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl9218456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:none;
                    border-right:none;
                    border-bottom:.5pt solid windowtext;
                    border-left:.5pt solid windowtext;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl9318456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:none;
                    border-right:.5pt solid windowtext;
                    border-bottom:.5pt solid windowtext;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  .xl9418456
                    {padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:black;
                    font-size:11.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:"Arial Narrow", sans-serif;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:center;
                    vertical-align:bottom;
                    border-top:none;
                    border-right:none;
                    border-bottom:.5pt solid windowtext;
                    border-left:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    white-space:normal;}
                  --></style>
                  </head>

                  <body>
                    <div id="print">
                      <button class="btn btn-primary">
                        <i class="fa fa-print"></i>&nbsp;&nbsp;PRINT
                      </button>
                    </div>
                  <!--[if !excel]>&nbsp;&nbsp;<![endif]-->
                  <!--The following information was generated by Microsoft Excel's Publish as Web
                  Page wizard.-->
                  <!--If the same item is republished from Excel, all information between the DIV
                  tags will be replaced.-->
                  <!----------------------------->
                  <!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
                  <!----------------------------->

                  <div id="Slip Cash Payment_18456" align=center x:publishsource="Excel">

                  <table border=0 cellpadding=0 cellspacing=0 width=742 class=xl6318456
                   style='border-collapse:collapse;table-layout:fixed;width:558pt'>
                   <col class=xl6318456 width=9 style='mso-width-source:userset;mso-width-alt:
                   329;width:7pt'>
                   <col class=xl6318456 width=64 style='width:48pt'>
                   <col class=xl6318456 width=99 style='mso-width-source:userset;mso-width-alt:
                   3620;width:74pt'>
                   <col class=xl6318456 width=96 style='mso-width-source:userset;mso-width-alt:
                   3510;width:72pt'>
                   <col class=xl6318456 width=74 style='mso-width-source:userset;mso-width-alt:
                   2706;width:56pt'>
                   <col class=xl6318456 width=64 style='width:48pt'>
                   <col class=xl6318456 width=98 style='mso-width-source:userset;mso-width-alt:
                   3584;width:74pt'>
                   <col class=xl6318456 width=40 style='mso-width-source:userset;mso-width-alt:
                   1462;width:30pt'>
                   <col class=xl6318456 width=64 style='width:48pt'>
                   <col class=xl6318456 width=70 style='mso-width-source:userset;mso-width-alt:
                   2560;width:53pt'>
                   
                   <col class=xl6318456 width=64 style='width:48pt'>
                   <tr class=xl6318456 height=12 style='mso-height-source:userset;height:9.0pt'>
                    <td height=12 class=xl6318456 width=9 style='height:9.0pt;width:7pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                    <td class=xl6318456 width=99 style='width:74pt'></td>
                    <td class=xl6318456 width=96 style='width:72pt'></td>
                    <td class=xl6318456 width=74 style='width:56pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                    <td class=xl6318456 width=98 style='width:74pt'></td>
                    <td class=xl6318456 width=40 style='width:30pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                    <td class=xl6318456 width=70 style='width:53pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr> 
                   <tr class=xl6318456 height=22 style='mso-height-source:userset;height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=6 class=xl6418456 width=495 style='width:372pt'>KOHICHA CAFE</td>
                    <td class=xl6518456 width=40 style='width:30pt'></td>
                    <td class=xl6518456 width=64 style='width:48pt'></td>
                    <td class=xl6518456 width=70 style='width:53pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6918456 height=17 style='mso-height-source:userset;height:12.75pt'>
                    <td height=17 class=xl6918456 width=9 style='height:12.75pt;width:7pt'></td>
                    <td colspan=6 class=xl6618456 width=495 style='width:372pt'>BUKTI PEMBAYARAN
                    KAS KECIL</td>
                    <td class=xl6718456 width=40 style='width:30pt'>No:</td>
                    <td colspan=2 class=xl6818456 width=134 style='width:101pt'>{{ $cash_payment->cash_payment_no }}</td>
                    <td class=xl6918456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=6 class=xl7018456 width=495 style='width:372pt'>Dibayarkan
                    Kepada: {{ $cash_payment->nik }} | {{ $cash_payment->employee_name }}</td>
                    <td class=xl6718456 width=40 style='width:30pt'>Tgl:</td>
                    <td colspan=2 class=xl6818456 width=134 style='width:101pt'>{{ $cash_payment->cash_payment_date }}</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=6 class=xl7118456 width=495 style='width:372pt'>Keterangan</td>
                    <td colspan=3 class=xl7118456 width=174 style='border-left:none;width:131pt'>Jumlah</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   @php
                    $total = 0;
                   @endphp
                   @foreach($cash_payment_detail as $cash_payment_dets)
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=6 class=xl7218456 width=495 style='border-right:.5pt solid black;
                    width:372pt'>&nbsp;{{ $cash_payment_dets->description }}</td>
                    <td colspan=3 class=xl7518456 width=174 style='border-right:.5pt solid black;
                    border-left:none;width:131pt'>{{ number_format($cash_payment_dets->debt_show,0) }}</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>

                   @php
                      $total += $cash_payment_dets->debt_show;
                   @endphp
                   @endforeach
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=6 class=xl7818456 width=495 style='width:372pt'>Total</td>
                    <td colspan=3 class=xl7818456 width=174 style='border-left:none;width:131pt'>@php echo number_format($total); @endphp</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=9 style='mso-height-source:userset;height:6.75pt'>
                    <td height=9 class=xl6318456 width=9 style='height:6.75pt;width:7pt'></td>
                    <td colspan=9 class=xl7918456 width=669 style='width:503pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=3 class=xl7118456 width=259 style='width:194pt'>Account</td>
                    <td colspan=2 class=xl7118456 width=138 style='border-left:none;width:104pt'>Code</td>
                    <td colspan=2 class=xl7118456 width=138 style='border-left:none;width:104pt'>Debit</td>
                    <td colspan=2 class=xl7118456 width=134 style='border-left:none;width:101pt'>Credit</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=3 class=xl8018456 width=259 style='border-right:.5pt solid black;
                    width:194pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=134 style='border-right:.5pt solid black;
                    border-left:none;width:101pt'>&nbsp;</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=3 class=xl8018456 width=259 style='border-right:.5pt solid black;
                    width:194pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=134 style='border-right:.5pt solid black;
                    border-left:none;width:101pt'>&nbsp;</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=3 class=xl8018456 width=259 style='border-right:.5pt solid black;
                    width:194pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=134 style='border-right:.5pt solid black;
                    border-left:none;width:101pt'>&nbsp;</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=3 class=xl8018456 width=259 style='border-right:.5pt solid black;
                    width:194pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=134 style='border-right:.5pt solid black;
                    border-left:none;width:101pt'>&nbsp;</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=3 class=xl8018456 width=259 style='border-right:.5pt solid black;
                    width:194pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=134 style='border-right:.5pt solid black;
                    border-left:none;width:101pt'>&nbsp;</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=3 class=xl8018456 width=259 style='border-right:.5pt solid black;
                    width:194pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=138 style='border-right:.5pt solid black;
                    border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8018456 width=134 style='border-right:.5pt solid black;
                    border-left:none;width:101pt'>&nbsp;</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=3 class=xl8318456 width=259 style='width:194pt'>Total</td>
                    <td colspan=2 class=xl8318456 width=138 style='border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8318456 width=138 style='border-left:none;width:104pt'>&nbsp;</td>
                    <td colspan=2 class=xl8318456 width=134 style='border-left:none;width:101pt'>&nbsp;</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td class=xl6518456 width=64 style='width:48pt'></td>
                    <td class=xl6518456 width=99 style='width:74pt'></td>
                    <td class=xl6518456 width=96 style='width:72pt'></td>
                    <td class=xl6518456 width=74 style='width:56pt'></td>
                    <td class=xl6518456 width=64 style='width:48pt'></td>
                    <td class=xl6518456 width=98 style='width:74pt'></td>
                    <td class=xl6518456 width=40 style='width:30pt'></td>
                    <td class=xl6518456 width=64 style='width:48pt'></td>
                    <td class=xl8418456 width=70 style='border-top:none;width:53pt'>&nbsp;</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=2 class=xl8518456 width=163 style='width:122pt'>Dibuatkan Oleh</td>
                    <td colspan=2 class=xl8518456 width=170 style='border-left:none;width:128pt'>Disetujui
                    Oleh</td>
                    <td colspan=2 class=xl8518456 width=162 style='border-left:none;width:122pt'>Dibukukan
                    Oleh</td>
                    <td colspan=3 class=xl8518456 width=174 style='border-left:none;width:131pt'>Diterima
                    Oleh</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='mso-height-source:userset;height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td colspan=2 rowspan=3 class=xl8618456 width=163 style='border-right:.5pt solid black;
                    border-bottom:.5pt solid black;width:122pt'>&nbsp;</td>
                    <td colspan=2 rowspan=3 class=xl8618456 width=170 style='border-right:.5pt solid black;
                    border-bottom:.5pt solid black;width:128pt'>&nbsp;</td>
                    <td colspan=2 rowspan=3 class=xl8618456 width=162 style='border-right:.5pt solid black;
                    border-bottom:.5pt solid black;width:122pt'>&nbsp;</td>
                    <td colspan=3 rowspan=3 class=xl8618456 width=174 style='border-right:.5pt solid black;
                    border-bottom:.5pt solid black;width:131pt'>&nbsp;</td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='mso-height-source:userset;height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=22 style='mso-height-source:userset;height:16.5pt'>
                    <td height=22 class=xl6318456 width=9 style='height:16.5pt;width:7pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <tr class=xl6318456 height=20 style='height:15.0pt'>
                    <td height=20 class=xl6318456 width=9 style='height:15.0pt;width:7pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                    <td class=xl6318456 width=99 style='width:74pt'></td>
                    <td class=xl6318456 width=96 style='width:72pt'></td>
                    <td class=xl6318456 width=74 style='width:56pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                    <td class=xl6318456 width=98 style='width:74pt'></td>
                    <td class=xl6318456 width=40 style='width:30pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                    <td class=xl6318456 width=70 style='width:53pt'></td>
                    <td class=xl6318456 width=64 style='width:48pt'></td>
                   </tr>
                   <![if supportMisalignedColumns]>
                   <tr height=0 style='display:none'>
                    <td width=9 style='width:7pt'></td>
                    <td width=64 style='width:48pt'></td>
                    <td width=99 style='width:74pt'></td>
                    <td width=96 style='width:72pt'></td>
                    <td width=74 style='width:56pt'></td>
                    <td width=64 style='width:48pt'></td>
                    <td width=98 style='width:74pt'></td>
                    <td width=40 style='width:30pt'></td>
                    <td width=64 style='width:48pt'></td>
                    <td width=70 style='width:53pt'></td>
                    <td width=64 style='width:48pt'></td>
                   </tr>
                   <![endif]>
                  </table>

                  </div>


                  <!----------------------------->
                  <!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
                  <!----------------------------->
                  </body>

                  </html>
                   </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .row --> 
  </div>
</div>
@stop


