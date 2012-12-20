<ul id="nav">
	<loop:pages>
		<li><a href="<var:path>"><var:name></a>
		 	<ul>
				<loop:childrenPages>
					<li><a href="<var:childPath>/"><var:childName></a></li>
					 	<ul>
							<loop:secondChildrenPages>
								<li><a href="<var:secondChildPath>/"><var:secondChildName></a></li>
							</loop:secondChildrenPages>
						</ul>
				</loop:childrenPages>
			</ul>
		</li>
	</loop:pages>
</ul>