<div class="leftFloat" style="width:50%">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;">
												<div class="boxTextDiv" style="width:250px;">
													<div class="boxInputDiv">
														<input type="hidden" name="<var:fieldName>" id="<var:fieldName>" value="<var:content>" style="width: 200px;">
														<div id="colorSelector<var:fieldName>" class="colorSelector"><div style="background-color: <var:content>"></div></div>
														<script type="text/javascript">
														$('#colorSelector<var:fieldName>').ColorPicker({
															color: '<var:content>',
															onShow: function (colpkr) {
																$(colpkr).fadeIn(500);
																return false;
															},
															onHide: function (colpkr) {
																$(colpkr).fadeOut(500);
																return false;
															},
															onChange: function (hsb, hex, rgb) {
																$('#colorSelector<var:fieldName> div').css('backgroundColor', '#' + hex);
																$('#<var:fieldName>').val('#' + hex);
															}
														});
			
														</script>	
													</div>
													<span class="boxText"><var:displayName></span>
												</div>
												<if:screenshot!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-maximize.png" border="0" title="<var:screenshot>"/></div>
												</if>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
											</div>
										</td>
										<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
										<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
										<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
									</tr>
								</table>
							</div>