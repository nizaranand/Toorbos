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
												<if:screenshot!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-maximize.png" border="0" title="<var:screenshot>"/></div>
												</if>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
												<div class="boxInputDiv">
													<if:fieldName==layout>
														<img src="images/cms/article_short.jpg" height="200"/> <input type="radio" name="<var:fieldName>" value="1" <if:content==1>checked</if>>
														<img src="images/cms/article_medium.jpg" height="200"/> <input type="radio" name="<var:fieldName>" value="2" <if:content==2>checked</if>>
													</if>
													<if:fieldName!=layout>
													<select id="<var:fieldName>" class="inputBoxStyle" name="<var:fieldName>" style="width: 360px;" /><option value="">Loading ...</option></select>
													<script type="text/javascript">
														if( !arrayOfContentPopulationFields ){
														 var arrayOfContentPopulationFields = new Array();
														}
														arrayOfContentPopulationFields.push("<var:fieldName>-<var:moduleName>-<var:content>");
													 </script> 
													 </if>
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