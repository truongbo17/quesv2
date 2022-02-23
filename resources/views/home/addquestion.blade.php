<link rel="stylesheet" href="{{ asset('assets/css/formaddquestion.css') }}">
<div>
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="head">
            <div class="name_profile">
                <img src="{{ Auth::user()->avatar }}" class="avatar" />
                <div class="q">
                    <h4>{{ Auth::user()->name }}</h4>
                </div>
            </div>
            <div class="icon">
                <label for="fileimage">
                    <div class="icon">
                        <img src="https://img.icons8.com/color/48/000000/add-image.png" class="svg" />
                    </div>
                </label>

                <img id="output" @error('imageQuestion') style="border:1px solid rgb(207, 45, 45);" @enderror
                    class="img-responsive" height="70" width="90" style="border: 1px solid #1da1f2" />
                <input name="imageQuestion" type="file" accept="image/*" id="fileimage" onchange="loadFile(event)"
                    hidden>
                <script>
                    var loadFile = function(event) {
                        var reader = new FileReader();
                        reader.onload = function() {
                            var output = document.getElementById('output');
                            output.src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    };
                </script>

            </div>
        </div>
        <div class="body">
            <h4>Category</h4>
            <div class="btm_icon form__input">
                <select @error('category_id') style="border-color: rgb(207, 45, 45);" @enderror name="category_id">
                    @foreach ($listcategory as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <h4>Tag</h4>
            <div class="btm_icon form__input">
                <select @error('tag_id') style="border-color: rgb(207, 45, 45);" @enderror multiple name="tag_id[]">
                    @foreach ($listtag as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form">
                <div class="flex">
                    <textarea name="title" class="in" rows="5" placeholder="Enter your question..."
                        wrap="hard" maxlength="500">{{ old('title') }}</textarea>
                </div>
                <button type="submit">
                    <img class="svg margin" src="https://img.icons8.com/fluency/48/000000/filled-sent.png" />
                </button>
            </div>
        </div>
    </form>

    @foreach ($errors->all() as $error)
        <p style="text-align: center; color: #a70000">
            {{ $error }}
        </p>
        <br />
    @endforeach

    @if (session('success'))
        <p style="text-align: center; color: rgb(16 189 53)">
            {{ session('success') }}
        </p>
    @endif

    @if (session('error'))
        <p style="text-align: center; color: #a70000">
            {{ session('error') }}
        </p>
    @endif

</div>
