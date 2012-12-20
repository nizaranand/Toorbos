<span class="EmailFriendForm">
<var:userThankYouTemplate>
<form name="userInput" action="<var:pagePath>" method="post">
<input type="hidden" name="formToEmailCommand" value="sendEmail">
<loop:children>
  <var:output>
</loop:children>
<br/>
<br/>
<INPUT type=button value="<var:buttonText>" name=Submit onClick="<var:submitAction>">
</form>
</span>
