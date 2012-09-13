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
    <meta name="keywords" content="modelismo, aeromodelismo, aero, planadores, aeromodelismo eletrico, park-flyer, slow-flyer, indoor, wing CG calculator (with multiple panels &amp; forward sweep), rc,r/c,radio,remote,control,model,electric, 
    plane,aircraft,fuel,airplane,heli,nitro,car,foamy,parkflyer,lipo,battery,brushless,video,gallery" />
    <meta itemprop="name" content="Flying Wing CG Calculator">
    <meta itemprop="description" content="HTML5 Flying Wing CG Calculator with support to multiple panels and forward sweep.">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/wingcgcalc.css">
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if IE]><script src="js/excanvas.compiled.js"></script><![endif]-->
    <script src="../js/jquery-1.7.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <!-- 
    <script src="../js/bootstrap-twipsy.js"></script>
    <script src="../js/bootstrap-popover.js"></script>
    <script src="../js/bootstrap-modal.js"></script>
    -->
    <script src="../js/wingcgcalc.js"></script>
    <script src="../js/base64.js"></script>
    <script src="../js/canvas2image.js"></script>
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
<?
if (!isset($_GET['unitsystem'])) {
    $_GET['panelsqty'] = 1;
    $_GET['unitsystem'] = 'metric';
    $_GET['cgpos'] = 20;
    $_GET['weight'] = 600;
    $_GET['panelspan1'] = 600;
    $_GET['chord0'] = 340;
    $_GET['chord1'] = 180;
    $_GET['sweep1'] = 300;
    $_GET['angle1'] = 26.57;
}
for ($i = 1; $i < 6; $i++) {
    if (!isset($_GET["panel$i"]) and isset($_GET["panelspan$i"]) and floatval($_GET["panelspan$i"])>0) {
        $_GET["angle$i"] = str_replace(',', '.', round(atan(floatval($_GET["sweep$i"])/floatval($_GET["panelspan$i"])) * (180/M_PI),2));
    }
}
?>
    <div id="navbar" class="navbar navbar-inverse">
        <div class="navbar-inner">
          <a class="brand" href="#">WingCGCalc</a>
          <ul class="nav">
            <li class="active"><a href="/"><? print _('Home'); ?></a></li>
            <li><a href="http://sergio.bruder.com.br/"><? print _('Blog'); ?></a></li>
            <li><a href="http://sergio.bruder.com.br/sobre/"><? print _('Contact'); ?></a></li>
            <li><a href="../pt_BR/" id="link_pt_BR"><img src="../img/flag_brasil.png"  width="22" height="16"></a></li>
            <li><a href="../en_US/" id="link_en_US"><img src="../img/flag_england.png" width="22" height="16"></a></li>
          </ul>
        </div>
    </div>

    <div class="container">
        <div class="content">
            <div class="page-header">
                <div class="row">
                    <div id="googlead" class="span10 offset2">
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
                <!-- <div class="row">
                    <div class="span12">
                        <h1><? print _('WingCGCalc'); ?></h1>
                    </div>
                </div> -->
            </div>
            <div class="row">
	            <div class="span12">
	                <!-- <h2><? print _('Wing'); ?></h2> -->
	                <canvas id="wingcanvas" width="940" height="300"></canvas>
	            </div>
            </div>
            <div class="row">
                <div class="span6">
                    <h2><? print _('Measures'); ?></h2>
                    <form id="measuresform" action="" class="form-horizontal" onsubmit="return false">
                        <input type="hidden" id="panelsqty" name="panelsqty" value="<?= $_GET['panelsqty'] ?>">
                        <input type="hidden" id="unitsystem" name="unitsystem" value="metric"> <? // to be fixed later in the js setup ?>
                        <fieldset class="control-group">
                            <legend><? print _('Options'); ?></legend>
                            <div class="control-group">
                                <label class="control-label" for="cgpos"><? print _('Unit System'); ?></label>
                                <div class="controls">
                            	<? if ($_GET['sys'] == 'imperial') { ?>
                                    <button id="btn_metric"   class="btn"><? print _('Metric'); ?></button>&nbsp;
                                    <button id="btn_imperial" class="btn btn-primary disabled"><? print _('Imperial'); ?></button>
                                    <script>
                                    // global variables setup
                                    window.systemunit = "imperial";
                                    </script>
                                <? } else { ?>
									<button id="btn_metric"   class="btn btn-primary disabled"><? print _('Metric'); ?></button>&nbsp;
									<button id="btn_imperial" class="btn"><? print _('Imperial'); ?></button>
                                    <script>
                                    // global variables setup
                                    window.systemunit = "metric";
                                    </script>
                                <? } ?>
                                </div>
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label" for="cgpos"><? print _('CG Position'); ?></label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input class="medium redraw" id="cgpos" name="cgpos" size="10" type="text" value="<?= $_GET['cgpos'] ?>"
                                            rel="popover" data-content="<? print _('For tailless wings, start with 15% for beginners going to 25% for experts. Trainers airplanes normally use 25-33%.'); ?>" data-original-title="<? print _('CG Position'); ?>">
                                        <span id="cgunit" class="add-on">%</span>
                                    </div>
                                    <span class="help-block"><small><? print _('15% for beginners, 25% for experts, 25-33% for airplanes.'); ?></small></span>
                                </div>
                            </div><!-- /control-group -->

                            <div class="control-group">
                                <label class="control-label" for="weight"><? print _('Weight'); ?></label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input class="medium redraw" id="weight" name="weight" size="10" type="text" value="<?= $_GET['weight'] ?>"
                                            rel="popover" data-content="<? print _('Enter the total flying weight to calculate the wing load.'); ?>" data-original-title="<? print _('Weight'); ?>">
                                        <span id="weightunit" class="add-on">g</span>
                                    </div>
                                </div>
                            </div><!-- /control-group -->

                            
							<div class="control-group">
							    <label class="control-label" for="drawmeasurement"><? print _('Measurement'); ?></label>
							    <div class="controls">
							        <label class="checkbox">
    						            <input type="checkbox" class="redraw" id="drawmeasurement" name="drawmeasurement" value="draw" 
    						            <? if ($_GET['drawmeasurement'] == 'draw') { print 'checked="yes"'; } ?> > 
    						            <? print _('Draw the measures.'); ?>
                                    </label>
							        
						        </div>
							    
							</div><!-- /control-group -->
							                            
                        </fieldset>

                        <fieldset class="control-group">
                            <legend>
                                Panel 1
                                <a href="#" id="addPanelBtn"    class="btn btn-success">+1</a>
                                <a href="#" id="removePanelBtn" class="btn btn-danger disabled">-1</a>
                            </legend>
                            <div class="control-group">
                                <label class="control-label" for="panelspan1"><? print _('Panel span'); ?></label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input class="medium redraw recalcangle" id="panelspan1" panel="1" name="panelspan1" size="10" type="text" value="<?= $_GET['panelspan1'] ?>"
                                            rel="popover" data-content="<? print _('Span of this panel in the semiwing (Ex: If your wing has 1200mm span and only one panel, use 600mm). Angle will be recalculated as needed.'); ?>" data-original-title="<? print _('Panel Span'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label" for="chord0"><? print _('Root chord'); ?></label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input class="medium redraw" id="chord0" panel="1" name="chord0" size="10" type="text" value="<?= $_GET['chord0'] ?>"
                                            rel="popover" data-content="<? print _('Chord in the root of this panel'); ?>" data-original-title="<? print _('Root Chord'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label" for="chord1"><? print _('Tip chord'); ?></label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input class="medium redraw" id="chord1" panel="1" name="chord1" size="10" type="text" value="<?= $_GET['chord1'] ?>"
                                            rel="popover" data-content="<? print _('Chord in the tip of this panel'); ?>" data-original-title="<? print _('Tip Chord'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label" for="sweep1"><? print _('Sweep'); ?></label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input class="medium redraw recalcangle" id="sweep1" panel="1" name="sweep1" size="10" type="text" value="<?= $_GET['sweep1'] ?>"
                                            rel="popover" data-content="<? print _('For forward swept wings use negative values. Enter the sweep value to calculate the angle and vice-versa.'); ?>" data-original-title="<? print _('Sweep'); ?>">
                                        <span class="add-on small">mm</span>
                                    </div>
                                </div>
                            </div><!-- /control-group -->
							<div class="control-group">
							    <label class="control-label" for="angle1"><? print _('Angle'); ?></label>
							    <div class="controls">
							        <div class="input-append">
							            <input class="medium redraw recalcsweep" id="angle1" panel="1" name="angle1" size="10" type="text" value="<?= $_GET['angle1'] ?>"
							                rel="popover" data-content="<? print _('For forward swept wings use negative values. Enter the angle in degrees to calculate the sweep value and vice-versa.'); ?>" data-original-title="<? print _('Angle'); ?>">
							            <span class="add-on small">&deg;</span>
							        </div>
							    </div>
							</div><!-- /control-group -->
                        </fieldset>
						<? for($p=2;$p<=6;$p++) {
						?>
							<? if ($_GET['panelsqty'] >= $p) { ?>
		                        <fieldset id="panel<? print $p; ?>" class="control-group">
	                        <? } else { ?>
		                        <fieldset id="panel<? print $p; ?>" class="control-group hide">
	                        <? } ?>
	                            <legend><? printf( _('Panel %d'),$p); ?></legend>
	                            <div class="control-group">
	                                <label class="control-label" for="panelspan<? print $p; ?>"><? print _('Panel span'); ?></label>
	                                <div class="controls">
	                                    <div class="input-append">
	                                        <input class="medium redraw recalcangle" id="panelspan<?= $p; ?>" panel="<?= $p; ?>" name="panelspan<?= $p; ?>" size="10"    value="<?= $_GET["panelspan$p"] ?>" type="text"
	                                            rel="popover" data-content="<? print _('Span of this panel in the semiwing (Ex: If your wing has 1200mm span and only one panel, use 600mm). Angle will be recalculated as needed.'); ?>" data-original-title="<? print _('Panel Span'); ?>">
	                                        <span class="add-on small">mm</span>
	                                    </div>
	                                </div>
	                            </div><!-- /control-group -->
	                            <div class="control-group">
	                                <label class="control-label" for="chord<? print $p; ?>"><? print _('Tip chord'); ?></label>
	                                <div class="controls">
	                                    <div class="input-append">
	                                        <input class="medium redraw" id="chord<? print $p; ?>" panel="<?= $p; ?>" name="chord<? print $p; ?>" size="10" value="<?= $_GET["chord$p"] ?>" type="text"
	                                            rel="popover" data-content="<? print _('Chord in the tip of this panel'); ?>" data-original-title="<? print _('Tip Chord'); ?>">
	                                        <span class="add-on small">mm</span>
	                                    </div>
	                                </div>
	                            </div><!-- /control-group -->
	                            <div class="control-group">
	                                <label class="control-label" for="sweep<? print $p; ?>"><? print _('Sweep'); ?></label>
	                                <div class="controls">
	                                    <div class="input-append">
	                                        <input class="medium redraw recalcangle" id="sweep<? print $p; ?>" panel="<?= $p; ?>" name="sweep<? print $p; ?>" size="10" value="<?= $_GET["sweep$p"] ?>" type="text"
	                                            rel="popover" data-content="<? print _('For forward swept wings panels use negative values.'); ?>" data-original-title="<? print _('Sweep'); ?>">
	                                        <span class="add-on small">mm</span>
	                                    </div>
	                                </div>
	                            </div><!-- /control-group -->
	                            <div class="control-group">
	                                <label class="control-label" for="angle<?= $p; ?>"><? print _('Angle'); ?></label>
	                                <div class="controls">
	                                    <div class="input-append">
	                                        <input class="medium redraw recalcsweep" id="angle<?= $p; ?>" panel="<?= $p; ?>" name="angle<?= $p; ?>" size="10" type="text" value="<?= $_GET["angle$p"] ?>"
	                                            rel="popover" data-content="<? print _('For forward swept wings use negative values. Enter the angle in degrees to calculate the sweep value and vice-versa.'); ?>" data-original-title="<? print _('Angle'); ?>">
	                                        <span class="add-on small">&deg;</span>
	                                    </div>
	                                </div>
	                            </div><!-- /control-group -->
	                        </fieldset>
						<? } ?>
                    </form>
                </div>
                <div class="span6">
                    <div>
                        <h2><? print _('Results'); ?></h2>
                        <form id="resultsform" class="form-horizontal" action="" class="" onsubmit="return false">
                        <input type="hidden" id="deeplinkurl" name="deeplinkurl" value="">                        
                            <fieldset class="control-group">
                                <div class="control-group">
                                    <label class="control-label" for="area"><? print _('Wing Area'); ?></label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input class="medium" id="area" name="area" size="10" type="text">
                                            <span id="areaunit" class="add-on small">dm&sup2;</span>
                                        </div>
                                    </div>
                                </div><!-- /control-group -->
                                <div class="control-group">
                                    <label class="control-label" for="macdist"><? print _('MAC Distance'); ?></label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input class="medium" id="macdist" name="macdist" size="10" type="text">
                                            <span class="add-on small">mm</span>
                                        </div>
                                    </div>
                                </div><!-- /control-group -->
                                <div class="control-group">
                                    <label class="control-label" for="maclen"><? print _('MAC Length'); ?></label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input class="medium" id="maclen" name="maclen" size="10" type="text">
                                            <span class="add-on small">mm</span>
                                        </div>
                                    </div>
                                </div><!-- /control-group -->
                                <div class="control-group">
                                    <label class="control-label" for="cgdist"><? print _('CG'); ?></label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input class="medium" id="cgdist" name="cgdist" size="10" type="text">
                                            <span class="add-on small">mm</span>
                                        </div>
                                    </div>
                                </div><!-- /control-group -->
                             
                                <div class="control-group">
                                    <label class="control-label" for="wingload"><? print _('Wing Load'); ?></label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input class="medium" id="wingload" name="wingload" size="10" type="text">
                                            <span id="wingloadunit" class="add-on small">g/dm&sup2;</span>
                                        </div>
                                    </div>
                                </div><!-- /control-group -->

								<div class="control-group">
								    <label class="control-label" for="publicurl"><? print _('Deep linking URL'); ?></label>
								    <div class="controls">
							            <input class="medium" id="publicurl" name="publicurl" size="300" type="text">
								    </div>
								</div><!-- /control-group -->
								<div class="control-group">
								    <div class="controls">
                                        <button id="btn_shortit" class="btn btn-primary"><? print _('Short it!'); ?></button>             
								    	<button id="btn_savepng" class="btn btn-primary"><? print _('Save image'); ?></button>
								    	<br/>
                                        <br/>
								    	<? print _("Note: We are limited by the current available API and cant choose an appropriate name of the saved file."); ?>
								    </div>
								</div><!-- /control-group -->
								<? /*
								<div class="control-group">
								    <label class="control-label" for="debug"><? print _('Debug info'); ?></label>
								    <div class="controls">
								        <textarea id="debug" name="debug" rows="10">
								        </textarea>
								    </div>
								</div><!-- /control-group --> 
								*/ ?>								
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>	
    </div> <!-- /container -->

    <br/>

    <div class="container">
        <div class="content">
            <div class="row">
                <div class="span3">
                    <h2><? print _('About'); ?></h2>
                    <p><small><? print _("Ive used the excelent work of z80 (<a href=\"http://fwcg.3dzone.dk/\">http://fwcg.3dzone.dk/</a>) in the past, but the limitations of one single panel and no forward sweep made me look for multi-panel CG calcs, and Ive found only very old windows programs. Accustomed to the online and direct use of z80's tool, Ive decided to make my own online CG calculator, with forward sweep and multiple panels."); ?>
                    </small></p>
                    <p><small><? print _("WingCGCalc is a flying wing CG calculator flexible enough to calculate complex wings, with multiple panels and forward swept. As the percentual position of the MAC for the CG is also configurable, you can use it with standard airplanes (with tail) too, It's only a question of configuring the right amount."); ?>
                    </small></p>
                </div>
                <div class="span3">
                    <h2><? print _('TODO'); ?></h2>
                    <ul>
                        <li><strike><small><? print _("Deep-link for wings designs"); ?></small></strike></li>
                        <li><strike><small><? print _("Better wing drawings: whole wing and measuring in the canvas"); ?></small></strike></li>
                        <li><strike><small><? print _("Better wing drawings 2, the mission: measuring in the canvas"); ?></small></strike></li>
                        <li><strike><small><? print _("No more DOS in bit.ly, manual URL shorting."); ?></small></strike></li>
                        <li><strike><small><? print _("Save canvas as image."); ?></small></strike></li>
                        <li><small><? print _("Save option to build a database of wings designs"); ?></small></li>
                        <li><small><? print _("Any other ideias? Please contact me."); ?></small></li>
                    </ul>
                </div>
                <div class="span6">
                    <h2><? print _('History'); ?></h2>
                    <ul>
                        <li><h4><? print _("v 1.6"); ?></h4>
                            <ul>
                                <li><small><? print _("Wing loading calculation."); ?></small></li>
                                <li><small><? print _("BUGFIX: URL shorting now has a smaller timeout, 2 seconds."); ?></small></li>
                                <li><small><? print _("BUGFIX: Small translation issues."); ?></small></li>
                            </ul>
                        </li>
                        <li><h4><? print _("v 1.5"); ?></h4>
                            <ul>
                                <li><small><? print _("Now with angle recalculated as needed when span and/or sweep values are changed and vice-versa."); ?></small></li>
                                <li><small><? print _("BUGFIX: Firefox fixes."); ?></small></li>
                                <li><small><? print _("URL shorting is now manual."); ?></small></li>
                            </ul>
                        </li>
                        <li><h4><? print _("v 1.4"); ?></h4>
                            <ul>
                                <li><small><? print _("BUGFIX: the MAC calculation for multi-panel was wrong, corrected thanks to LaercioLMB from e-voo.com."); ?></small></li>
                                <li><small><? print _("New display code and html arrange in the page now shows the whole wing."); ?></small></li>
                            </ul>
                        </li>
                        <li><h4><? print _("v 1.3.1"); ?></h4>
                            <ul>
                                <li><small><? print _("if the url shortening fails in any way use the full URL instead."); ?></small></li>
                            </ul>
                        </li>                       
                        <li><h4><? print _("v 1.3"); ?></h4>
                            <ul>
                                <li><small><? print _("big rework to allow deep linking to arbitrary wings with bit.ly url shorting."); ?></small></li>
                            </ul>
                        </li>
                        <li><h4><? print _("v 1.2.1"); ?></h4>
                            <ul>
                                <li><small><? print _("i18n bugfixing."); ?></small></li>
                                <li><small><? print _("A proper build system, Makefile and so on."); ?></small></li>
                            </ul>
                        </li>
                        
                        <li><h4><? print _("v 1.2"); ?></h4>
                            <ul>
                                <li><small><? print _("Added About and History in end of the page."); ?></small></li>
                                <li><small><? print _("Proper internationalization with gettext support. If you want wingcgcalc in your language and can contribute with the translation, please contact me."); ?></small></li>
                                <li><small><? print _("Options moved to the start of the measures forms, a few users didnt found the CG % with it the end."); ?></small></li>
                                <li><small><? print _("Popups implemented with little helper texts for each entry."); ?></small></li>
                            </ul>
                        </li>
                        <li><h4><? print _("v 1.1"); ?></h4>
                            <ul>
                                <li><small><? print _("Brazilian Portuguese translation added."); ?></small></li>
                                <li><small><? print _("Unit system switch between metric and imperial systems."); ?></small></li>
                                <li><small><? print _("A little less broken with Internet Explorers (still without canvas support)."); ?></small></li>
                            </ul>
                        </li>
                        <li><h4><? print _("v 1.0"); ?></h4>
                            <ul>
                                <li><small><? print _("Initial version."); ?></small></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <footer>
            <p>&copy; Sergio Bruder 2011-2012</p>
        </footer>
    </div>

    <div id="noIE" class="modal hide fade">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3><? print _('Internet Explorer not supported'); ?></h3>
            </div>
            <div class="modal-body">
              <p><? print _('WingCGCalc uses a great deal of HTML5, javascript and canvas support, which Internet Explorer currently cant support (there is no CANVAS in Internet Explorer, for example). Sorry. Use any other modern browser.'); ?></p>
            </div>
            <div class="modal-footer">
              <a href="#" data-dismiss="modal" class="btn primary"><? print _('Ok'); ?></a>
            </div>
    </div>
    <script>
        $(document).ready(function(){
        	<? if ($_GET['unitsystem'] != 'metric') { ?>
	        	systemunits_to_imperial(false);
        	<? } ?>
            wingcgcalc_setup();
            draw_wing();

            if (jQuery.browser.msie) { // Allways Internet Explorer. SUX.
                $("#noIE").modal('show');
            }
        });
    </script>
</body>
</html>
