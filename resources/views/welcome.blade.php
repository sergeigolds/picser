HERE WILL BE API DOCUMENTATION LIKE https://api.elkogroup.com/

<form action="{{ route('store')  }}" method="post" enctype="multipart/form-data" style="margin-top: 100px;">
    <label for="img">
        <input
            class="form-control input-md @error('img') not-validated @enderror"
            id="img"
            name="img"
            placeholder="Image src"
            type="file"/>
    </label>
    @error('img')
    <div class="error-message">
        {{ $message }}
    </div>
    @enderror

    <input type="submit" value="Submit">
</form>
