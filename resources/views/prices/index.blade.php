@extends('layouts.app')

@section('link')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('style')
<style>
    .error {
        border: 2px dotted #cc5965;
    }
</style>
@endsection

@section('content')
@include('shared.messages')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.prices_arr.index.prices_list')}}</h3>
                </br>
            </div>

            <div class="panel-body">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <form method="POST" id="update_prices" action="{{ route('admin.prices.update') }}">
                                {{ method_field('PATCH') }}
                                {{ csrf_field() }}
                                
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Region</th>
                                            @for($i=1;$i<12;$i++)
                                            <th>H{{$i}}</th>
                                            @endfor
                                            @for($i=1;$i<12;$i++)
                                            <th>M{{$i}}</th>
                                            @endfor
                                            @for($i=1;$i<12;$i++)
                                            <th>S{{$i}}</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($prices as $price)
                                    <tr>
                                        <td><input type="hidden" name="id[]" value="{{$price->id}}"/>{{$price->name!='' ? $price->name : 'Abroad'}}</td>
                                        @for($i=1;$i<12;$i++)
                                            <td><input class="number" type="text" style="width:40px;" id="{{'H'.$i}}" name="{{'H'.$i}}[]" value="{{$price['H'.$i]}}"/></td>
                                        @endfor
                                        @for($i=1;$i<12;$i++)
                                            <td><input class="number" type="text" style="width:40px;" id="{{'M'.$i}}" name="{{'M'.$i}}[]" value="{{$price['M'.$i]}}"/></td>
                                        @endfor
                                        @for($i=1;$i<12;$i++)
                                            <td><input class="number" type="text" style="width:40px;" id="{{'S'.$i}}" name="{{'S'.$i}}[]" value="{{$price['S'.$i]}}"/></td>
                                        @endfor
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <div class="col-sm-12" style='text-align: center;'>
                                        <button type="submit" class="btn btn-primary">{{__('texte.prices_arr.index.save')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>


<script type="text/javascript" charset="utf-8">
   
    $(document).on('input','.number' ,function() {
        $(this).removeClass('error');
        
        $(this).val($(this).val().replace(/,/g, '.')); 
        
        var valid =/^\d+\.?\d{0,5}$/.test(this.value),
        val = this.value;

        if(!valid){
            this.value = val.substring(0, val.length - 1);
        }  
    });
    
    
    $('button[type="submit"]').on('click', function(e){
        e.preventDefault();
        $('.number').each(function() {
            if($(this).val()==0 || $(this).val()==''){
                $(this).addClass('error');
            } 
        });
        
        if($('.error').length>0){
            alert('Please fill all fields');
        }
        else{
            $('#update_prices').submit();
        }
    });
</script>
@endsection