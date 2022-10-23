@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">楽曲を探す</div>

                <div class="card-body">
                  <input id="serch_keyword" type="text"><input id="serch_button" type="button" value="検索">
　　　　　　　　　　<div class="result"></div><!--ここに検索結果を表示します-->
                  <script type="text/javascript" src="{{ asset('/js/search.js') }}"></script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
