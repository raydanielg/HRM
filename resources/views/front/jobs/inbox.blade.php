@extends('front.layouts.frontlayout')

@section('head')

{{HTML::style("assets/global/css/components.css")}}
{{HTML::style("assets/global/css/plugins.css")}}
{{HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")}}
<style>
/* CSS used here will be applied after bootstrap.css */

body{ margin-top:50px;}
.nav-tabs .glyphicon:not(.no-margin) { margin-right:10px; }
.tab-pane .list-group-item:first-child {border-top-right-radius: 0px;border-top-left-radius: 0px;}
.tab-pane .list-group-item:last-child {border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;}
.tab-pane .list-group .checkbox { display: inline-block;margin: 0px; }
.tab-pane .list-group input[type="checkbox"]{ margin-top: 2px; }
.tab-pane .list-group .glyphicon { margin-right:5px; }
.tab-pane .list-group .glyphicon:hover { color:#FFBC00; }
a.list-group-item.read { color: #222;background-color: #F3F3F3; }
hr { margin-top: 5px;margin-bottom: 10px; }
.nav-pills>li>a {padding: 5px 10px;}

.ad { padding: 5px;background: #F5F5F5;color: #222;font-size: 80%;border: 1px solid #E5E5E5; }
.ad a.title {color: #15C;text-decoration: none;font-weight: bold;font-size: 110%;}
.ad a.url {color: #093;text-decoration: none;}
</style>
@stop

@section('mainarea')
            <div class="col-md-9">

                <!--Profile Body-->
                <div class="profile-body">

                 <div class="row">
                     <div class="col-sm-3 col-md-2">

                     </div>
                     <div class="col-sm-9 col-md-10">
                         <!-- Split button -->

                         <button type="button" class="btn btn-default" data-toggle="tooltip" title="Refresh">
                             &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;&nbsp;</button>
                         <!-- Single button -->
                         <div class="btn-group">
                             <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                 More <span class="caret"></span>
                             </button>
                             <ul class="dropdown-menu" role="menu">
                                 <li><a href="#">Mark all as read</a></li>
                                 <li class="divider"></li>
                                 <li class="text-center"><small class="text-muted">Select messages to see more actions</small></li>
                             </ul>
                         </div>
                         <div class="pull-right">
                             <span class="text-muted"><b>1</b>–<b>50</b> of <b>160</b></span>
                             <div class="btn-group btn-group-sm">
                                 <button type="button" class="btn btn-default">
                                     <span class="glyphicon glyphicon-chevron-left"></span>
                                 </button>
                                 <button type="button" class="btn btn-default">
                                     <span class="glyphicon glyphicon-chevron-right"></span>
                                 </button>
                             </div>
                         </div>
                     </div>
                 </div>
                 <hr>
                 <div class="row">
                     <div class="col-sm-3 col-md-2">
                         <a href="#" class="btn btn-danger btn-sm btn-block" role="button"><i class="glyphicon glyphicon-edit"></i> Compose</a>
                         <hr>
                         <ul class="nav nav-pills nav-stacked">
                             <li class="active"><a href="#"><span class="badge pull-right">32</span> Inbox </a>
                             </li>

                             <li><a href="#">Sent Mail</a></li>

                         </ul>
                     </div>
                     <div class="col-sm-9 col-md-10">
                         <!-- Nav tabs -->

                         <!-- Tab panes -->
                         <div class="tab-content">
                             <div class="tab-pane fade in active" id="home">
                                 <div class="list-group">
                                     <a href="#" class="list-group-item">
                                         <div class="checkbox">
                                             <label>
                                                 <input type="checkbox">
                                             </label>
                                         </div>
                                         <span class="glyphicon glyphicon-star-empty"></span><span class="name" style="min-width: 120px;
                                             display: inline-block;">Mark Otto</span> <span class="">Nice work on the lastest version</span>
                                         <span class="text-muted" style="font-size: 11px;">- More content here</span> <span class="badge">12:10 AM</span> <span class="pull-right"><span class="glyphicon glyphicon-paperclip">
                                             </span></span></a><a href="#" class="list-group-item">
                                                 <div class="checkbox">
                                                     <label>
                                                         <input type="checkbox">
                                                     </label>
                                                 </div>
                                                 <span class="glyphicon glyphicon-star-empty"></span><span class="name" style="min-width: 120px;
                                                     display: inline-block;">Jason Markus</span> <span class="">This is big title</span>
                                                 <span class="text-muted" style="font-size: 11px;">- I saw that you had..</span> <span class="badge">12:09 AM</span> <span class="pull-right"><span class="glyphicon glyphicon-paperclip">
                                                     </span></span></a><a href="#" class="list-group-item read">
                                                         <div class="checkbox">
                                                             <label>
                                                                 <input type="checkbox">
                                                             </label>
                                                         </div>
                                                         <span class="glyphicon glyphicon-star"></span><span class="name" style="min-width: 120px;
                                                             display: inline-block;">Jane Patel</span> <span class="">This is big title</span>
                                                         <span class="text-muted" style="font-size: 11px;">- Hi hello how r u ?</span> <span class="badge">11:30 PM</span> <span class="pull-right"><span class="glyphicon glyphicon-paperclip">
                                                             </span></span></a>
                                 </div>
                             </div>
                             <div class="tab-pane fade in" id="profile">
                                 <div class="list-group">
                                     <div class="list-group-item">
                                         <span class="text-center">This tab is empty.</span>
                                     </div>
                                 </div>
                             </div>

                         </div>


                     </div>
                 </div>
             </div>



</div>


@stop

@section('footerjs')

<!-- BEGIN PAGE LEVEL PLUGINS -->

	{{ HTML::script("assets/global/plugins/datatables/media/js/jquery.dataTables.min.js")}}
	{{ HTML::script("assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js")}}


<!-- END PAGE LEVEL PLUGINS -->
<script>
	function ShowApplyForm(){
		$('#apply_button').hide();
		$('#apply_job_form').fadeIn();
	}
     @if(Session::get('success') || $errors->has())
     	   ShowApplyForm();
     @endif
</script>

@stop