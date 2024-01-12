<% include Banner %>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="main col-sm-8">
                <% with $Property %>
                <div class="blog-main-image">
                    $PrimaryPhoto.SetWidth(750)
                </div>
                <hr>
                <div class="share-wraper col-sm-12 clearfix">
                    <h3>Description</h3>
                    <p>$Description</p>
                    <h3>Type</h3>
                    <p>$PropertyType.Name</p>
                    <h3>Address</h3>
                    <p>$Address</p>
                    <h3>Price</h3>
                    <p>$PricePerNight</p>
                    <h3>Bedrooms</h3>
                    <p>$Bedrooms</p>
                    <h3>Bathrooms</h3>
                    <p>$Bathrooms</p>
                    <h3>AvailableStart</h3>
                    <p>$AvailableStart.Long</p>
                    <h3>Available</h3>
                    <p>$AvailableEnd.Long</p>

                </div>

                <div class="comments">
                    <ul>
                        <li>
                            <img src="$Agent.Photo.URL" alt="" />
                            <div class="comment">
                                <h3>$Agent.Name</h3>
                                <p>Address : $Agent.Address</p>
                                <p>Phone : <a href="https://wa.me/+62$Agent.Phone">$Agent.Phone</a></p>

                                <h5>About</h5>
                                $Agent.About
                            </div>
                        </li>

                    </ul>
                </div>
                <!-- <h4>Agent : $Agent.Name</h4>
                <h4>Phone : $Agent.Phone</h4>
                <h4>Address : $Agent.Address</h4> -->
                <% end_with %>

            </div>
            <div class="sidebar gray col-sm-4">

                <h2 class="section-title">Facility</h2>
                <ul class="categories subnav">
                    <% loop $Facilities %>
                    <li class="">
                        <a class="" href="">$Name</a>
                    </li>
                    <% end_loop %>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->