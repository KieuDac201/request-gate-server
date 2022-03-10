<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send Mail</title>
</head>
<style>
body{
 
}
.box{
  max-width: 500px;
  width: 100%;
  margin: 0 auto;
}
h1{
  padding: 20px;
  display : flex;
  justify-content: center;
  margin: 0 auto;
  color: blue;
}
a {
  text-decoration: none;
}
header{
    background-color: #4DBE9C;
    width:100%;
    color: white;
    font-size:20px;
    padding:20px;
  text-align:center;
}
.content{
  width:100%;
  justify-content: center;
  display : flex;
}
table{
  width:100%;
  border:1px solid #CCC;
}
tr,td {
  border: 1px solid #CCC;
}
.box_id {
  width : 20%;
  text-align: center;
}
h3{
  margin-top:15px;
  font-size: 18px;
  color: black;
  text-align: center;
}
button {
  background : #4DBE9C;
  font-size: 18px;
  padding: 12px 50px;
  display : flex;
  justify-content: center;
  margin: 0 auto;
  border-radius: 9px;
  border: none;
}
button a{
  color: white;
}
.submit {
  width : 100%;
  margin-top: 20px;
}
</style>
<body>
  <div class="box">
    <div class="image">
      <h1>Request Gate</h1>
      </div>
 
<div clas="container">
  <header> Báo cáo dự án HBL_HBFuture 
    <br> {{$data['day']}} <br>
  </header>
    <h3>
      {{$data['name']}} vừa {{$data['type']}} Request 
    </h3>
  <div class="content">
    <table>
      <tr>
        <td class="box_id">
          <a href="{{$data['link']}}/{{$data['id']}}">{{$data['id']}}</a>
        </td>
        <td>
          <p>
            <br> {{$data['title']}} <br>
            Status : {{$data['status']}} | Assignee : {{$data['person_in_charge']}}
          </p>
        </td>
      </tr>
    </table>
  </div>
  <div class= "submit">
        <button><a href="{{$data['link']}}/{{$data['id']}}">Go To</a></button>
  </div>
</div>
</div>
</body>
</html>