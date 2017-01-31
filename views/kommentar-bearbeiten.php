<?php
require_once('../classes/Login.php');
$title="Themenwahl";
include ("_header_in.php");

?>
<script>setCommentEditView();</script>

<div class="content">

	<div class="medien_info">
		
<?php
		$comment_id = $_POST['comment_id'];
		$comment = $_POST['comment'];
		$topic_id = $_POST['topic_id'];
?>

		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="themenwahl_comment_form">
			<input type="hidden" name="edited_comment[comment_id]" value="<?=$comment_id?>">
			<textarea class="edit_comment_inputarea" name="edited_comment[comment]"><?=$comment?></textarea><br>
			<input type="submit" class="inputbutton" id="edit_comment_inputbutton" name="edit_comment_submit" value="Kommentar speichern">
		</form>
		<script>focusEndOfTextarea();</script>
<?php
		if(isset($_POST['edited_comment'])){echo "<script>CloseChildRefreshParent();</script>";}
?>		

		
	</div>
</div>