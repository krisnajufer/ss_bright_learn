<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
    <div class="container">
        <div class="row">

            <!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm-8">


                <!-- BEGIN BLOG LISTING -->
                <div class="grid-style1 clearfix">
                    <% loop $Regions %>
                    <div class="item col-md-12">
                        <div class="image image-large">
                            <a href="$Link">
                                <span class="btn btn-default"><i class="fa fa-file-o"></i> Read More</span>
                            </a>
                            $Photo.CroppedImage(720,255)
                        </div>
                        <div class="info-blog">
                            <h3>
                                <a href="$Link">$Title</a>
                            </h3>
                            $Description.FirstParagraph
                        </div>
                    </div>
                    <% end_loop %>

                </div>
                <!-- END BLOG LISTING -->


                <!-- BEGIN PAGINATION -->
                <% if $Regions.MoreThanOnePage %>
                <div class="pagination">
                    <ul id="previous">
                        <li><a href="#"><i class="fa fa-chevron-left"></i></a></li>
                    </ul>
                    <% if $Regions.NotFirstPage %>
                    <ul id="previous">
                        <li><a href="$Regions.PrevLink"><i class="fa fa-chevron-left"></i></a></li>
                    </ul>
                    <% end_if %>
                    <ul>
                        <% loop $Regions.PaginationSummary %>
                        <li <% if $CurrentBool %>class="active" <% end_if %>>
                            <a href="$Link">$PageNum</a>
                        </li>

                        <% end_loop %>
                    </ul>
                    <% if $Regions.NotLastPage %>
                    <ul id="next ">
                        <li><a href="$Regions.NextLink"><i class="fa fa-chevron-right"></i></a></li>
                    </ul>
                    <% end_if %>
                </div>
                <% end_if %>
                <!-- END PAGINATION -->

            </div>
            <!-- END MAIN CONTENT -->


            <!-- BEGIN SIDEBAR -->
            <div class="sidebar gray col-sm-4">


                <!-- BEGIN LATEST NEWS -->
                <h2 class="section-title">Popular articles</h2>
                <ul class="latest-news">
                    <% loop $Articles %>
                    <li class="col-md-12">
                        <div class="image">
                            <a href="$Link"></a>
                            <img src="$Photo.SetWidth(100).URL" alt="" />
                        </div>

                        <ul class="top-info">
                            <li><i class="fa fa-calendar"></i> $Date.Long</li>
                        </ul>

                        <h3><a href="blog-detail.html">$Teaser</a></h3>
                    </li>
                    <% end_loop %>

                </ul>
                <!-- END LATEST NEWS -->

            </div>
            <!-- END SIDEBAR -->

        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->