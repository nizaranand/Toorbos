<div class="leftFloat" style="width:100%">	
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
													<span class="boxText"><var:displayName></span>
												</div>
												<div style="float:right;padding:2px;cursor:pointer;" onclick="Javascript: closeField('<var:fieldName>');" id="<var:fieldName>Close"><img src="images/Fiber/icn-minimize.png" border="0" title="Minimize wysiwyg"/></div>
												<div style="float:right;display:none;padding:2px;cursor:pointer;" onclick="Javascript: openField('<var:fieldName>');" id="<var:fieldName>Open"><img src="images/Fiber/icn-maximize.png" border="0" title="Maximize wysiwyg"/></div>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
												<div class="boxInputDiv" width="100%" id="<var:fieldName>Content">
													<textarea name="<var:fieldName>" id="<var:fieldName>" cols="75" rows="5" onkeyup="Javascript: characterCount('<var:fieldName>');"><var:content></textarea>
													<div id="<var:fieldName>Display"></div>
													<script type="text/javascript"> characterCount('<var:fieldName>'); </script>
												</div>
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