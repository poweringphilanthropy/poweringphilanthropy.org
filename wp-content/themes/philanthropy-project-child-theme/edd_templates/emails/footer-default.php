<?php
/**
 * Email Footer
 *
 * @author 		Easy Digital Downloads
 * @package 	Easy Digital Downloads/Templates/Emails
 * @version     2.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// For gmail compatibility, including CSS styles in head/body are stripped out therefore styles need to be inline. These variables contain rules which are added to the template inline.
$template_footer = "
	border-top:0;
	-webkit-border-radius:3px;
";

$credit = "
	border:0;
	color: #000000;
	font-family: 'Roboto', Helvetica, Arial, 'Lucida Grande', sans-serif;
	font-size:14px;
	line-height:125%;
	text-align:center;
";
$pledge = "text-align:center;color: #fff;background: #000;padding: 14px 14px;text-decoration: none;font-weight: bold;";
?>
															</div>
														</td>
                                                    </tr>
                                                </table>
                                                <!-- End Content -->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Body -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Footer -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer" style="<?php echo $template_footer; ?>">
                                        <tr>
                                            <td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
												
													<tr>
														<td style="text-align:center;">
															<a style="<?php echo $pledge;?>" href="<?php echo esc_url( home_url() );?>#pledgenow">PLEDGE YOUR DAY, TOO!</a> 
														</td>
													</tr>
                                                    <tr>
                                                        <td colspan="2" valign="middle" id="credit" style="<?php echo $credit; ?>">
                                                           <?php echo wpautop( wp_kses_post( wptexturize( apply_filters( 'edd_email_footer_text', '<a style="font-size:14px;color:#000;font-weight:bold;text-decoration:none;" href="' . esc_url( home_url() ) . '">www.givemyday.com</a>' ) ) ) ); ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Footer -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>