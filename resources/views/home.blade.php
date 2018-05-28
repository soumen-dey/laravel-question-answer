@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
            <div class="input-group input-group-lg mb-3">
                <input type="text" v-model="searchText" class="form-control input-with-border" placeholder="Search for...">
                <div class="input-group-append">
                    <span class="input-group-text input-group-append-with-border" id="basic-addon2"><i class="fa fa-search"></i></span>
                </div>
            </div>
            <h4 class="text-gray mb-3" v-if="showSearchQuery">Searching for <b v-text="searchText"></b></h4>
            <h4 class="text-gray mb-3" v-if="hasNoData">No results for <b v-text="searchText"></b></h4>
            <div v-if="showSearchResult">
                <div class="card margin-bottom-big" v-for="data in responseData">
                    <div class="card-body">
                        <h4 class="text-gray">@{{ data.title }}</h4>

                        <hr />

                        <small class="text-muted"><i class="fa fa-clock"></i> @{{ data.created_at }}</small>&nbsp;&nbsp;&nbsp;
                        <small class="text-muted"><i class="fa fa-eye"></i> @{{ data.views }}</small>&nbsp;&nbsp;&nbsp;
                        <small class="text-muted"><i class="fa fa-pencil-alt"></i> @{{ data.answers }}</small>

                        <a :href="data.link" class="btn btn-outline-primary btn-sm float-right margin-right-short">View Question</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center" v-if="showQuestionRow">
        <div class="col-md-8">
            @foreach($questions as $question)
                <div class="card margin-bottom-big">
                    <div class="card-body">
                        <h4 class="text-gray">{{ $question->title }}</h4>

                        @if($question->hasBestAnswer())
                            <p class="card-text text-gray">{{ $question->hasBestAnswer() }}</p>
                        @endif

                        <hr />

                        <small class="text-muted"><i class="fa fa-clock"></i> {{ $question->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
                        <small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($question->views->count()) }}</small>&nbsp;&nbsp;&nbsp;
                        <small class="text-muted"><i class="fa fa-pencil-alt"></i> {{ _number_format($question->answers->count()) }}</small>

                        @if($question->isFollowing())
                            <button class="btn btn-success btn-sm float-right"
                                    @click.prevent="followQuestion"
                                    data-id="{{ $question->id }}">
                                <i class="fa fa-check"></i> Following | {{ _number_format($question->follows->count()) }}
                            </button>
                        @else
                            <button class="btn btn-outline-secondary btn-sm float-right"
                                    @click.prevent="followQuestion"
                                    data-id="{{ $question->id }}">
                                <i class="fa fa-plus"></i> Follow | {{ _number_format($question->follows->count()) }}
                            </button>
                        @endif

                        <a href="{{ route('questions.show', $question->slug) }}" class="btn btn-outline-primary btn-sm float-right margin-right-short">View Question</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/vue.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/axios.js') }}"></script>
<script type="text/javascript">
    var app = new Vue({
        el: '#app',

        data: {
            searchText: '',
            showSearchQuery: false,
            showQuestionRow: true,
            responseData: {},
            showSearchResult: false,
            hasNoData: false
        },

        watch: {
            searchText: function() {
                let length = this.searchText.length;
                this.hasNoData = false;
                this.responseData = {};

                if (length >= 1) {
                    this.showQuestionRow = false;
                    this.showSearchQuery = true;
                } else {
                    this.showQuestionRow = true;
                    this.showSearchQuery = false;
                    this.showSearchResult = false;
                }

                if (length >= 5) {
                    this.showSearchResult = true;
                    this.searchQuestions();
                }
            }
        },

        methods: {
            searchQuestions: function() {
                let self = this;
                axios.get("{{ route('search.questions') }}?q="+this.searchText)
                    .then(function(response) {
                        if (response.data.length > 0) {
                            self.responseData = response.data;
                            self.hasNoData = false;
                        } else {
                            self.responseData = {};
                            self.hasNoData = true;
                        }
                    });
            }
        }
    });
</script>
@endsection
