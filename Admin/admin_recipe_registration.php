<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レシピ管理</title>
    <link rel="stylesheet" href="admin_recipe_registration.css">
        <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <!-- パンくずリスト -->
    <ul class="breadcrumb">
        <a href="admin_top.html">管理者TOP</a> >
        <a href="admin_list_of_recipe.html">登録レシピ一覧</a> >
        <span>レシピ登録/編集</span>
    </ul>    

    <h1>レシピ登録/編集</h1>

    <div class="container">
        <div class="recipe-form">
            <form id="recipeForm">
                <label for="recipe_id">レシピID</label>
                <div class="masked-text" id="recipe_id">******</div>

                <label for="recipe_name">レシピ名</label>
                <input type="text" id="recipe_name" required>

                <p><label for="recipe_file_path1">レシピ写真1</label>
                <button type="button">アップロード</button></p> 

                <p><label for="recipe_file_path2">レシピ写真2</label>
                <button type="button">アップロード</button></p>

                <p><label for="recipe_file_path3">レシピ写真3</label>
                <button type="button">アップロード</button></p>
<!--
                <label for="process_1">手順1</label>
                <textarea id="process_1" rows="6" required></textarea>

                <label for="process_2">手順2</label>
                <textarea id="process_2" rows="6" required></textarea>

                <label for="process_3">手順3</label>
                <textarea id="process_3" rows="6" required></textarea>-->

                <!-- 利用食品 -->
                <h2>利用食品</h2>
                <table class="ingredients-table">
                    <thead>
                        <tr>
                             <th>食品名</th>
                            <th>表示用使用料</th>
                            <th>単位</th>
                            <th>算出用値</th>

<!--<input type="number" id="number-of-unit" name="unit" value="1" min="0" max="10">人前
-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!--<input type="number" id="number-of-unit"
                            name="unit" value="1" min="0" max="10">人前-->
                            <!--<td>食品1</td>
                            <td>100g</td>
                            <td>2</td>
                            <td>2</td>-->
                            <td><input type="text" id="number-of-unit"
                                name=""></td>
                             <td><input type="number" id="number-of-unit"
                                name="unit" value="1" min="0" max="10"></td>
                             <td><select name="options" id="options">
                                <option value="option1">g</option>
                                <option value="option2">個</option>
                                <option value="option3">本</option>
                                <option value="option4">枚</option>
                                <option value="option4">パック</option>
                                <option value="option4">束</option>
                                <option value="option4">玉</option>
                                <option value="option4">株</option>
                                <option value="option4">節</option>
                                <option value="option4">匹</option>
                            </select> </td>
                            <td><input type="text" id="number-of-unit"
                                name="">g</td>
                           
                        </tr>
                        <tr>
                            <td><input type="text" id="number-of-unit"
                                name=""></td>
                             <td><input type="number" id="number-of-unit"
                                name="unit" value="1" min="0" max="10"></td>
                             <td><select name="options" id="options">
                                <option value="option1">g</option>
                                <option value="option2">個</option>
                                <option value="option3">本</option>
                                <option value="option4">枚</option>
                                <option value="option4">パック</option>
                                <option value="option4">束</option>
                                <option value="option4">玉</option>
                                <option value="option4">株</option>
                                <option value="option4">節</option>
                                <option value="option4">匹</option>
                            </select> </td>
                            <td><input type="text" id="number-of-unit"
                                name="">g</td>
                        </tr>
                    </tbody>
                </table>

                <!-- 利用調味料 -->
                <h2>利用調味料</h2>
                <table class="seasonings-table">
                    <thead>
                        <tr>
                            <th>調味料名</th>
                            <th>使用料</th>
                            <th>単位</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><select name="options" id="options">
                                <option value="option1">g</option>
                                <option value="option2">個</option>
                                <option value="option3">本</option>
                                <option value="option4">枚</option>
                                <option value="option4">パック</option>
                                <option value="option4">束</option>
                                <option value="option4">玉</option>
                                <option value="option4">株</option>
                                <option value="option4">節</option>
                                <option value="option4">匹</option>
                            </select> </td>
                             <td><input type="number" id="number-of-unit"
                                 name="unit" value="1" min="0" max="10"></td>
                            <td><select name="options" id="options">
                                <option value="option1">g</option>
                                <option value="option2">個</option>
                                <option value="option3">本</option>
                                <option value="option4">枚</option>
                                <option value="option4">パック</option>
                                <option value="option4">束</option>
                                <option value="option4">玉</option>
                                <option value="option4">株</option>
                                <option value="option4">節</option>
                                <option value="option4">匹</option>
                            </select>      </td>
                        </tr>
                        <tr>
                            <td><select name="options" id="options">
                                <option value="option1">g</option>
                                <option value="option2">個</option>
                                <option value="option3">本</option>
                                <option value="option4">枚</option>
                                <option value="option4">パック</option>
                                <option value="option4">束</option>
                                <option value="option4">玉</option>
                                <option value="option4">株</option>
                                <option value="option4">節</option>
                                <option value="option4">匹</option>
                            </select> </td>
                             <td><input type="number" id="number-of-unit"
                                 name="unit" value="1" min="0" max="10"></td>
                            <td><select name="options" id="options">
                                <option value="option1">g</option>
                                <option value="option2">個</option>
                                <option value="option3">本</option>
                                <option value="option4">枚</option>
                                <option value="option4">パック</option>
                                <option value="option4">束</option>
                                <option value="option4">玉</option>
                                <option value="option4">株</option>
                                <option value="option4">節</option>
                                <option value="option4">匹</option>
                            </select>      </td>
                        </tr>
                    </tbody>
                </table>

                <label for="process_1">手順1</label>
                <textarea id="process_1" rows="6" required></textarea>

                <label for="process_2">手順2</label>
                <textarea id="process_2" rows="6" required></textarea>

                <label for="process_3">手順3</label>
                <textarea id="process_3" rows="6" required></textarea>
            </form>
        </div>
                <div class="button-container">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modal">削除</button>
                    <button class="update">更新</button>
                </div>


                    <!-- モーダル -->
        <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <p>レシピ******を削除します。</p><br>
                            <p>よろしいですか？</p>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">はい</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
