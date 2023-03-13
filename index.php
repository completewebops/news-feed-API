<?php 
$apikey="Your api key here between the quotes";
?>
<!DOCTYPE html>
<html>

<head>
    <title>News Feed</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="text-center my-4">Top Headlines CNBC</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4" id="news-feed"></div>
    </div>

    <script>
        $(document).ready(function() {
            var curlResponse = <?php
                                    $curl = curl_init();
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($curl, CURLOPT_URL,
                                        "https://www.newsapi.ai/api/v1/article/getArticles?query=%7B%22%24query%22%3A%7B%22%24and%22%3A%5B%7B%22locationUri%22%3A%22http%3A%2F%2Fen.wikipedia.org%2Fwiki%2FUnited_States%22%7D%2C%7B%22sourceUri%22%3A%22cnbc.com%22%7D%2C%7B%22dateStart%22%3A%222023-03-11%22%2C%22dateEnd%22%3A%222023-03-12%22%7D%5D%7D%7D&resultType=articles&articlesSortBy=date&articlesCount=100&includeArticleImage=true&includeArticleVideos=true&articleBodyLen=-1&apiKey=$apikey"
                                    );
                                    $result = json_decode(curl_exec($curl), true);
                                    echo json_encode($result);
                                ?>;
            var articles = curlResponse.articles.results;
            if (articles) {
                articles.forEach(function(article) {
                    var cardHtml = '<div class="col mb-4">' +
                        '<div class="card h-100">' +
                        '<img class="card-img-top" src="' + article.image + '">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' + article.title + '</h5>' +
                        '<a href="' + article.url + '" class="btn btn-primary">Read more</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    $('#news-feed').append(cardHtml);
                });
            } else {
                $('#news-feed').append('<p class="text-center">No articles found</p>');
            }
        });
    </script>
</body>

</html>
