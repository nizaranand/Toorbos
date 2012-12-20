<table width="200" border="0" cellspacing="1" cellpadding="5">
<loop:pages>
<tr>
<td colspan="3" class="sitemap_level1"><a href="<var:path>" title="<var:name>" class="sitemap"><var:name></a></td>
</tr>
		<loop:childrenPages>
		<tr>
		<td width="20" class="sitemap_level1">&gt;</td>
		<td width="100%" colspan="2" class="sitemap_level2"><a href="<var:childPath>" title="<var:childName>" class="sitemap"><var:childName></a></td>
		</tr>
			<loop:secondChildrenPages>
			<tr>
			<td width="20">&nbsp;</td>
			<td width="20" class="sitemap_level2">&gt;</td>
			<td width="100%" class="sitemap_level3"><a href="<var:secondChildPath>/" class="sitemap"><var:secondChildName></a></td>
			</tr>
			</loop:secondChildrenPages>
		</loop:childrenPages>
</loop:pages>
</table>