<?php include './db_connect.php' ?>

<div class="container-fluid">
<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.5); /* IE */
  -moz-transform: scale(1.5); /* FF */
  -webkit-transform: scale(1.5); /* Safari and Chrome */
  -o-transform: scale(1.5); /* Opera */
  transform: scale(1.5);
  padding: 10px;
}
.list-group-item +  .list-group-item {
    border-top-width: 1px !important;
}
</style>

	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				
				<div class="card">
					<div class="card-header">
						<b>Articles</b>
                        <?php if($_SESSION['login_type'] == 1): ?>
						    <span class="">

							    <button class="btn navbar-color btn-block text-white btn-sm col-sm-2 float-right" type="button" id="new_article">
					            <i class="fa fa-plus"></i> Add article</button>
				            </span>
                            <?php endif; ?>
					</div>
					<div class="card-body">
						<ul class="w-100 list-group" id="topic-list">
							<?php
							$article = $conn->query("SELECT * FROM articles order by title asc");
							while($row= $article->fetch_assoc()):
							?>
							<li class="list-group-item mb-4">
								<div>
									<?php if($_SESSION['login_type'] == 1): ?>
					                    <div class="dropleft float-right mr-4">
					                      <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					                        <span class="fa fa-ellipsis-v"></span>
					                      </a>
					                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					                        <a class="dropdown-item edit_topic" data-id="<?php echo $row['article_id'] ?>" href="javascript:void(0)">Edit</a>
					                        <a class="dropdown-item delete_topic" data-id="<?php echo $row['article_id'] ?>" href="javascript:void(0)">Delete</a>
					                      </div>
					                    </div> 	
									<?php else: ?>	
										<div class="dropleft float-right mr-4">
					                      <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					                        <span class="fa fa-ellipsis-v"></span>
					                      </a>
					                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					                        <a class="dropdown-item report_topic" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Report Post</a>
					                      </div>
					                    </div> 	
				                    <?php endif; ?>
				                    <span class="float-right mr-4"><small><i>Created: <?php echo date('M d, Y h:i A',strtotime($row['added_at'])) ?></i></small></span>
									<a href="index.php?page=information_resources/view_article&id=<?php echo $row['article_id'] ?>"
									 class=" filter-text"><?php echo $row['title'] ?></a>

								</div>

							</li>
						<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height:150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$('#topic-list').JPaging({
	    pageSize: 15,
	    visiblePageSize: 10

	  });

	$('#new_article').click(function(){
		uni_modal("Article","information_resources/manage_article.php",'mid-large')
	})

    /*
	$('.edit_topic').click(function(){
		uni_modal("Edit Topic","manage_topic.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	$('.delete_topic').click(function(){
		_conf("Are you sure to delete this topic?","delete_topic",[$(this).attr('data-id')],'mid-large')
	})

	$('.report_topic').click(function(){
		uni_modal("Report Post","manage_report_post.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
    */
	function delete_topic($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_topic',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>