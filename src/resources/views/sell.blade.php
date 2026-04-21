    @extends('layouts.app')

    @section('title', '出品画面 - COACHTECH')

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/sell.css') }}">

    @endsection


    @section('content')
    <div class="container">
        <h2 class="page-title">商品の出品</h2>

        <form action="/sell" method="POST" enctype="multipart/form-data">
            @csrf

            <section>
                <h3 class="section-title">商品画像</h3>
                <div class="image-upload-wrapper">
                    <input type="file" id="item_image" name="item_image" style="display: none;" onchange="previewImage(this)" accept="image/*">
                    
                    <label for="item_image" class="image-upload-btn">
                        画像を選択する
                    </label>
                    
                    @error('item_image')
                        <p class="error-message" style="color: red;">{{ $message }}</p>
                    @enderror

                    <div id="preview-container" class="hidden" style="margin-top: 1.5rem;">
                        <img id="preview" src="#" alt="プレビュー" style="max-width: 100%; height: auto;">
                    </div>  
                </div>
            </section>


            <section>
                <h3 class="section-title">商品の詳細</h3>
                <div class="form-group">
                    <label class="input-label">カテゴリー</label>
                    <div class="category-container">
                        @foreach(['ファッション', '家電', 'インテリア', 'レディース', 'メンズ', 'コスメ', '本', 'ゲーム'] as $index => $cat)
                        <div class="category-item">
                            <input type="checkbox" name="categories[]" value="{{ $index+1 }}" id="cat{{ $index+1 }}">
                            <label for="cat{{ $index+1 }}" class="category-label">{{ $cat }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label for="condition" class="input-label">商品の状態</label>
                    <select name="condition" id="condition" class="custom-select">
                        <option value="" disabled selected>選択してください</option>
                        <option value="1">良好</option>
                        <option value="2">目立った傷や汚れなし</option>
                        <option value="3">やや傷や汚れあり</option>
                        <option value="4">状態が悪い</option>
                    </select>
                </div>
            </section>

            <section>
                <h3 class="section-title">商品名と説明</h3>
                <div class="form-group">
                    <label for="name" class="input-label">商品名</label>
                    <input type="text" name="name" id="name" class="custom-input">
                </div>
                <div class="form-group">
                    <label for="description" class="input-label">商品の説明</label>
                    <textarea name="description" id="description" class="custom-textarea"></textarea>
                </div>
                <div class="form-group">
                    <label for="price" class="input-label">販売価格</label>
                    <div class="price-input-container">
                        <input type="number" name="price" id="price" class="custom-input" placeholder="0">
                    </div>
                </div>
            </section>

            <button type="submit" class="submit-btn">出品する</button>
        </form>
    </div>
    @endsection

    @section('script')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const container = document.getElementById('preview-container');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    container.classList.remove('hidden'); // 画像がある時だけ表示
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                container.classList.add('hidden'); // キャンセルされたら隠す
            }
        }
    </script>
    @endsection