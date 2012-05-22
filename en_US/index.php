<?
// gettext setup
include('../php/i18n.php');
?>
<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/tool">
<head>
    <meta charset="utf-8">
    <title><? print _('Flying Wing CG Calculator'); ?></title>
    <meta name="description" content="Flying wing CG calculator with multiple panels and forward sweep) - Flying Wings" />
    <meta name="keywords" content="modelismo, aeromodelismo, aero, tutoriais, planadores, pacaembu, aeromodelismo eletrico, eletrico, bateria, 
    motor, carregador, servo, esc, speed control, receptor, transmissor, 72mhz, park-flyer, slow-flyer, indoor, motoplanador, multimotor, 
    hidroaviao, ESC, brushless, LiPo wing CG calculator (with multiple panels &amp; forward sweep), rc,r/c,radio,remote,control,model,electric, 
    plane,aircraft,fuel,airplane,heli,nitro,car,foamy,parkflyer,lipo,battery,brushless,video,gallery" />
    <meta itemprop="name" content="Flying Wing CG Calculator">
    <meta itemprop="description" content="HTML5 Flying Wing CG Calculator with support to multiple panels and forward sweep.">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/wingcgcalc.css">
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if IE]><script src="js/excanvas.compiled.js"></script><![endif]-->
    <script src="../js/jquery-1.7.1.min.js"></script>
    <script src="../js/bootstrap-twipsy.js"></script>
    <script src="../js/bootstrap-popover.js"></script>
    <script src="../js/bootstrap-modal.js"></script>
    <script src="../js/wingcgcalc-1.2.js"></script>
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-27285625-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
</head>
<body>

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="#">WingCGCalc v1.2.1</a>
          <ul class="nav">
            <li class="active"><a href="/"><? print _('Home'); ?></a></li>
            <li><a href="http://sergio.bruder.com.br/"><? print _('Blog'); ?></a></li>
            <li><a href="http://sergio.bruder.com.br/sobre/"><? print _('Contact'); ?></a></li>
            <li><a href="../pt_BR/"><img src="../imgs/flag_brasil.png"  width="22" height="16"></a></li>
            <li><a href="../en_US/"><img src="../imgs/flag_england.png" width="22" height="16"></a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">
        <div class="content">
            <div class="page-header">
                <div class="row">
                    <div class="span3">
                        <h1><? print _('WingCGCalc'); ?></h1>
                    </div>
                    <div id="googlead" class="span13">
                        <script type="text/javascript"><!--
                        google_ad_client = "ca-pub-8746171184192742";
                        /* cgcalc-big */
                        google_ad_slot = "4782211755";
                        google_ad_width = 728;
                        google_ad_height = 90;
                        //-->
                        </script>
                        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                        </script>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="span6">
                    <h2><? print _('Measures'); ?></h2>
                    <form id="measuresform" action="" class="" onsubmit="return false">
                        <input type="hidden" id="panelsqty" name="panelsqty" value="1">

                        <fieldset>
                            <legend><? print _('Options'); ?></legend>
                            <div class="clearfix">
                                <label for="cgpos"><? print _('Unit System'); ?></label>
                                <div class="input">
                                    <button id="btn_metric"   class="btn primary disabled"><? print _('Metric'); ?></button>&nbsp;
                                    <button id="btn_imperial" class="btn"><? print _('Imperial'); ?></button>
                                </div>
                            </div><!-- /clearfix -->
                            <div class="clearfix">
                                <label for="cgpos"><? print _('CG Position'); ?></label>
                                <div class="input">
                                    <div class="input-append">
                                        <input class="medium redraw" id="cgpos" name="cgpos" size="10" type="text" value="20"
                                            rel="popover" data-content="<? print _('For tailless wings, start with 15% for beginners going to 25% for experts. Trainers airplanes normally use 25-33%.'); ?>" data-original-title="<? print _('CG Position'); ?>">
                                        <span id="cgunit" class="add-on">%</span>
                                    </div>
                                    <span class="help-block"><? print _('15% for beginners, 25% for experts, 25-33% for airplanes.'); ?></span>
                                </div>
                            </div><!-- /clearfix -->
                            <!--<div class="actions">
                                <input type="submit" id="calc"   class="btn primary" value="Calc"> 
                                <button type="reset" id="cancel" class="btn">Cancel</button>
                            </div>--!>
                        </fieldset>

                        <fieldset>
                            <legend>
                                Panel 1
                                <a href="#" id="addPanelBtn"    class="btn success">+1</a>
                                <a href="#" id="removePanelBtn" class="btn danger disabled">-1</a>
                            </legend>
                            <div class="clearfix">
                                <label for="panelspan1"><? print _('Panel span'); ?></label>
                                <div class="input">
                                    <div class="input-append">
                                        <input class="medium redraw" id="panelspan1" name="panelspan1" size="10" type="text" value="600"
                                            rel="popover" data-content="<? print _('Span of this panel in the semiwing (Ex: If your wing has 1200mm span and only one panel, use 600mm).'); ?>" data-original-title="<? print _('Panel Span'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /clearfix -->
                            <div class="clearfix">
                                <label for="chord0"><? print _('Root chord'); ?></label>
                                <div class="input">
                                    <div class="input-append">
                                        <input class="medium redraw" id="chord0" name="chord0" size="10" type="text" value="340"
                                            rel="popover" data-content="<? print _('Chord in the root of this panel'); ?>" data-original-title="<? print _('Root Chord'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /clearfix -->
                            <div class="clearfix">
                                <label for="chord1"><? print _('Tip chord'); ?></label>
                                <div class="input">
                                    <div class="input-append">
                                        <input class="medium redraw" id="chord1" name="chord1" size="10" type="text" value="180"
                                            rel="popover" data-content="<? print _('Chord in the tip of this panel'); ?>" data-original-title="<? print _('Tip Chord'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /clearfix -->
                            <div class="clearfix">
                                <label for="sweep1"><? print _('Sweep'); ?></label>
                                <div class="input">
                                    <div class="input-append">
                                        <input class="medium redraw" id="sweep1" name="sweep1" size="10" type="text" value="300"
                                            rel="popover" data-content="<? print _('For forward swept wings use negative values.'); ?>" data-original-title="<? print _('Sweep'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /clearfix -->
                        </fieldset>
<? for($p=2;$p<=6;$p++) {
?>
                        <fieldset id="panel<? print $p; ?>" class="hide">
                            <legend><? printf( _('Panel %d'),$p); ?></legend>
                            <div class="clearfix">
                                <label for="panelspan<? print $p; ?>"><? print _('Panel span'); ?></label>
                                <div class="input">
                                    <div class="input-append">
                                        <input class="medium redraw" id="panelspan<? print $p; ?>" name="panelspan<? print $p; ?>" size="10" type="text"
                                            rel="popover" data-content="<? print _('Span of this panel in the semiwing (Ex: If your wing has 1200mm span and only one panel, use 600mm).'); ?>" data-original-title="<? print _('Panel Span'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /clearfix -->
                            <div class="clearfix">
                                <label for="chord<? print $p; ?>"><? print _('Tip chord'); ?></label>
                                <div class="input">
                                    <div class="input-append">
                                        <input class="medium redraw" id="chord<? print $p; ?>" name="chord<? print $p; ?>" size="10" type="text"
                                            rel="popover" data-content="<? print _('Chord in the tip of this panel'); ?>" data-original-title="<? print _('Tip Chord'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /clearfix -->
                            <div class="clearfix">
                                <label for="sweep<? print $p; ?>"><? print _('Sweep'); ?></label>
                                <div class="input">
                                    <div class="input-append">
                                        <input class="medium redraw" id="sweep<? print $p; ?>" name="sweep<? print $p; ?>" size="10" type="text"
                                            rel="popover" data-content="<? print _('For forward swept wings panels use negative values.'); ?>" data-original-title="<? print _('Sweep'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /clearfix -->
                        </fieldset>
<? } ?>

                    </form>
                </div>
                <div class="span10">
                    <div>
                        <h2><? print _('Wing'); ?></h2>
                        <canvas id="wingcanvas" width="0" height="0"></canvas>
                    </div>
                    <div>
                        <h2><? print _('Results'); ?></h2>
                        <form id="resultsform" action="" class="">
                            <fieldset>
                                <div class="clearfix">
                                    <label for="area"><? print _('Wing Area'); ?></label>
                                    <div class="input">
                                        <div class="input-append">
                                            <input class="medium" id="area" name="area" size="10" type="text">
                                            <span id="areaunit" class="add-on small">dm&sup2;</span>
                                        </div>
                                    </div>
                                </div><!-- /clearfix -->
                                <div class="clearfix">
                                    <label for="macdist"><? print _('MAC Distance'); ?></label>
                                    <div class="input">
                                        <div class="input-append">
                                            <input class="medium" id="macdist" name="macdist" size="10" type="text">
                                            <span class="add-on small">mm</span>
                                        </div>
                                    </div>
                                </div><!-- /clearfix -->
                                <div class="clearfix">
                                    <label for="maclen"><? print _('MAC Length'); ?></label>
                                    <div class="input">
                                        <div class="input-append">
                                            <input class="medium" id="maclen" name="maclen" size="10" type="text">
                                            <span class="add-on small">mm</span>
                                        </div>
                                    </div>
                                </div><!-- /clearfix -->
                                <div class="clearfix">
                                    <label for="cgdist"><? print _('CG'); ?></label>
                                    <div class="input">
                                        <div class="input-append">
                                            <input class="medium" id="cgdist" name="cgdist" size="10" type="text">
                                            <span class="add-on small">mm</span>
                                        </div>
                                    </div>
                                </div><!-- /clearfix -->
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="span16">
                    <h2><? print _('About'); ?></h2>
                    <p><? print _("Ive used the excelent work of z80 (<a href=\"http://fwcg.3dzone.dk/\">http://fwcg.3dzone.dk/</a>) in the past, but the limitations of one single panel and no forward sweep made me look for multi-panel CG calcs, and Ive found only very old windows programs. Accustomed to the online and direct use of z80's tool, Ive decided to make my own online CG calculator, with forward sweep and multiple panels."); ?></p>
                    <p><? print _("WingCGCalc is a flying wing CG calculator flexible enough to calculate complex wings, with multiple panels and forward swept. As the percentual position of the MAC for the CG is also configurable, you can use it with standard airplanes (with tail) too, It's only a question of configuring the right amount."); ?></p>

                    <h2><? print _('TODO'); ?></h2>
                    <ul>
                        <li><? print _("Deep-link for wings designs"); ?></li>
                        <li><? print _("Save option to build a database of wings designs"); ?></li>
                        <li><? print _("Some helper drawings exemplifying in the wing image what is the current measure been edited."); ?></li>
                        <li><? print _("Any other ideias? Please contact me."); ?></li>
                    </ul>

                    <h2><? print _('History'); ?></h2>
                    <ul>
	                    <li><h4><? print _("v 1.2.1"); ?></h4>
	                        <ul>
	                            <li><? print _("i18n bugfixing."); ?></li>
	                            <li><? print _("A proper build system, Makefile and so on."); ?></li>
	                        </ul>
	                    </li>
	                    
                        <li><h4><? print _("v 1.2"); ?></h4>
                            <ul>
                                <li><? print _("Added About and History in end of the page."); ?></li>
                                <li><? print _("Proper internationalization with gettext support. If you want wingcgcalc in your language and can contribute with the translation, please contact me."); ?></li>
                                <li><? print _("Options moved to the start of the measures forms, a few users didnt found the CG % with it the end."); ?></li>
                                <li><? print _("Popups implemented with little helper texts for each entry."); ?></li>
                            </ul>
                        </li>
                        <li><h4><? print _("v 1.1"); ?></h4>
                            <ul>
                                <li><? print _("Brazilian Portuguese translation added."); ?></li>
                                <li><? print _("Unit system switch between metric and imperial systems."); ?></li>
                                <li><? print _("A little less broken with Internet Explorers (still without canvas support)."); ?></li>
                            </ul>
                        </li>
                        <li><h4><? print _("v 1.0"); ?></h4>
                            <ul>
                                <li><? print _("Initial version."); ?></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>	
        <footer>
            <p>&copy; Sergio Bruder 2011</p>
        </footer>
    </div> <!-- /container -->
    <div id="noIE" class="modal hide fade">
            <div class="modal-header">
              <a href="#" class="close">×</a>
              <h3><? print _('Internet Explorer not supported'); ?></h3>
            </div>
            <div class="modal-body">
              <p><? print _('WingCGCalc uses a great deal of HTML5, javascript and canvas support, which Internet Explorer currently cant support (there is no CANVAS in Internet Explorer, for example). Sorry. Use any other modern browser.'); ?></p>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn primary"><? print _('Ok'); ?></a>
            </div>
    </div>
    <script>
        $(document).ready(function(){
            wingcgcalc_setup();
            draw_wing();

            if (jQuery.browser.msie) { // Allways Internet Explorer. SUX.
                $("#noIE").modal('show');
            }
        });
    </script>
</body>
</html>
