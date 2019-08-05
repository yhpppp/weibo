@if($feed_list->count()>0)
<ul class="list-unstyled">
    @foreach($feed_list as $status)
    @include('statuses._status',['user'=>$status->user])
    @endforeach
</ul>
<div class="mt-5">
    {!! $feed_list->render() !!}
</div>
@else
<p>没有数据！</p>
@endif