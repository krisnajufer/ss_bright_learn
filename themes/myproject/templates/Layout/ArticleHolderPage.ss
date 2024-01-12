<% include Banner %>
<div class="content">
	<div class="container">
		<div class="row">

			<!-- BEGIN MAIN CONTENT -->
			<div class="main col-sm-8">


				<div id="blog-listing" class="list-style clearfix">
					<div class="row">
						<% if $SelectedRegion %>
						<h3>Region: $SelectedRegion.Title</h3>
						<% else_if $SelectedCategory %>
						<h3>Category: $SelectedCategory.Title</h3>
						<% else_if $StartDate %>
						<h3>Date: $StartDate.Full to $EndDate.Full</h3>
						<% end_if %>

						<% loop $getPaginatedArticles %>
						<div class="item col-md-6">
							<div class="image">
								<a href="$Link">
									<span class="btn btn-default">Read More</span>
								</a>
								$Photo.CroppedImage(242,156)
							</div>
							<div class="tag"><i class="fa fa-file-text"></i></div>
							<div class="info-blog">
								<ul class="top-info">
									<li><i class="fa fa-calendar"></i> $Date.Long</li>
									<li><i class="fa fa-comments-o"></i> 2</li>
									<li><i class="fa fa-tags"></i> $CategoriesList</li>
								</ul>
								<h3>
									<a href="$Link">$Title</a>
								</h3>
								<p><% if $Teaser %>$Teaser<% else %>$Content.FirstSentence<% end_if %></p>
							</div>
						</div>
						<% end_loop %>
					</div>
				</div>


				<!-- BEGIN PAGINATION -->
				<% if $getPaginatedArticles.MoreThanOnePage %>
				<div class="pagination">
					<% if $getPaginatedArticles.NotFirstPage %>
					<ul id="previous col-xs-6">
						<li><a href="$getPaginatedArticles.PrevLink"><i class="fa fa-chevron-left"></i></a></li>
					</ul>
					<% end_if %>
					<ul class="hidden-xs">
						<% loop $getPaginatedArticles.PaginationSummary %>
						<% if $Link %>
						<li <% if $CurrentBool %>class="active" <% end_if %>>
							<a href="$Link">$PageNum</a>
						</li>
						<% else %>
						<li>...</li>
						<% end_if %>
						<% end_loop %>
					</ul>
					<% if $getPaginatedArticles.NotLastPage %>
					<ul id="next col-xs-6">
						<li><a href="$getPaginatedArticles.NextLink"><i class="fa fa-chevron-right"></i></a></li>
					</ul>
					<% end_if %>
				</div>
				<% end_if %>
				<!-- END PAGINATION -->

			</div>
			<!-- END MAIN CONTENT -->


			<!-- BEGIN SIDEBAR -->
			<div class="sidebar gray col-sm-4">

				<h2 class="section-title">Categories</h2>
				<ul class="categories">
					<% loop $Categories %>
					<li><a href="$Link">$Title <span>($Articles.count)</span></a></li>
					<% end_loop %>
				</ul>

				<!-- BEGIN ARCHIVES ACCORDION -->
				<h2 class="section-title">Archives</h2>
				<div id="accordion" class="panel-group blog-accordion">
					<div class="panel">
						<!--
						<div class="panel-heading">
							<div class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="">
									<i class="fa fa-chevron-right"></i> 2014 (15)
								</a>
							</div>
						</div>
					-->
						<div id="collapseOne" class="panel-collapse collapse in">
							<div class="panel-body">
								<ul>
									<% loop $ArchiveDates %>
									<li><a href="$Link">$MonthName $Year ($ArticleCount)</a></li>
									<% end_loop %>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- END  ARCHIVES ACCORDION -->






			</div>
			<!-- END SIDEBAR -->

		</div>
	</div>
</div>