@extends('layouts.app')

@section('title', $user->name . ' 的激活')

@section('content')

<div class="row">

    <h1><p class="text-center">此账号还没激活请到查看邮件并激活</p></h1>
    <p class="text-center"><button type="button" class="btn btn-primary btn-lg" onclick="email( {{ Auth::id() }} )">重发激活邮件</button></p>
</div>

<script type="text/javascript">
    function email(user_id){ 
        $.get("/user/SendActivationEmail/"+user_id,function(data,status){
            
            if(status == 'success'){ 
                alert('發送成功請查收郵件');
            }
        });
    }

</script>

@stop
