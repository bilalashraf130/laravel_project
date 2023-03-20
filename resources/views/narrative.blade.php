

<style>
    .form-style{
        max-width: 450px;
        background: #FAFAFA;
        padding: 30px;
        margin: 50px auto;
        box-shadow: 1px 1px 25px rgba(0, 0, 0, 0.35);
        border-radius: 10px;
        border: 2px solid #305A72;
        font-family: 'Montserrat', sans-serif;
    }
    .form-style ul{
        padding:0;
        margin:0;
        list-style:none;
    }
    .form-style ul li{
        display: block;
        margin-bottom: 10px;
        min-height: 35px;
    }
    .form-style ul li  .field-style{
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        padding: 8px;
        outline: none;
        border: 1px solid #B0CFE0;
        font-family: 'Montserrat', sans-serif;
    }
    .form-style ul li  .field-style:focus{
        box-shadow: 0 0 5px #B0CFE0;
        border:1px solid #B0CFE0;
    }
    .form-style ul li .field-split{
        width: 100%;
    }
    .form-style ul li .field-full{
        width: 100%;
    }
    .form-style ul li input.align-left{
        float:left;
    }
    .form-style ul li input.align-right{
        float:right;
    }
    .form-style ul li textarea{
        width: 100%;
        height: 100px;
    }
    .form-style ul li input[type="button"],
    .form-style ul li input[type="submit"] {


        background-color: #f36f5b;
        border: 2px solid #f36f5b;
        display: inline-block;
        cursor: pointer;
        color: #FFFFFF;
        padding: 8px 18px;
        text-decoration: none;
    }
    .btn-narrative{
        background-color: #f36f5b;
        border: 2px solid #f36f5b;
        display: inline-block;
        cursor: pointer;
        color: #FFFFFF;
        padding: 8px 18px;
        text-decoration: none;
    }
    .alert {
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        font-size: 17px;
    }
    .alert-danger {
        color: #f36f5b;
        background-color: #d6d8d9;
        border-color: #c6c8ca;
    }

</style>

<form method="POST" id="user_activity_feed" class="form-style">
    @csrf
    <h4>Add Your Narrative!</h4>
    <ul>
        <li>
            <input type="text" name="narrative" id="narrative" class="field-style field-split align-left" placeholder="Narrative" />

        </li>
        <li>
            <input type="text" name="whats_on_your_mind" id="what_on_your_mind" class="field-style field-split align-left" placeholder="Whats on your Mind " />
        </li>
        <li>
            <input type="text" name="thought_concern" id="thought_concern" class="field-style field-full align-none" placeholder="Thought Concern" />
        </li>
        <li>
            <textarea name="your_hope" id="your_hope" class="field-style" placeholder="Your Hope"></textarea>
        </li>
        <li>
            <button class="btn-narrative" type="submit" > Submit</button>
           <a href="{{url('/add-count')}}">Add count</a>
        </li>


    </ul>
    @if($msg != null)
    <div id="message" class="alert alert-danger" role="alert">
            {{ $msg}}
    </div>
    @endif
</form>
