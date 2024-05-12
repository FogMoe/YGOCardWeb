<?php
include 'protectedFolder/View.php'; 

$view = new View();
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$pageSize = 10; // 每页显示10条记录
$search = isset($_GET['search']) ? $_GET['search'] : null;

$cards = $view->getCardsPageViewByIdOrName($search, $search, $page, $pageSize);
$totalCards = $view->getTotalCardCount();
$totalPages = ceil($totalCards / $pageSize);

function buildPageUrl($page) {
    $queryParams = $_GET;
    $queryParams['page'] = $page;
    return http_build_query($queryParams);
}

$nextPageUrl = buildPageUrl($page + 1);
$previousPageUrl = buildPageUrl($page - 1);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOGMOE YGO Card List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>FOGMOE YGO Card List</h1>
    <form method="GET">
        <label for="search">卡片 ID/名称:</label>
        <input type="text" id="search" name="search" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">查询</button>
    </form>



    <div class="cardList">
        <?php foreach ($cards as $card): ?>
            <div class="card">
                <div class="cardLin1">
                    <span class="cardName"><?= htmlspecialchars($card['name']) ?></span>
                    <span class="cardAttribute"><?= htmlspecialchars($card['attribute']) ?></span>
                </div>
                <div class="cardLin2">
                    <span class="cardId">ID:<?= htmlspecialchars($card['id']) ?></span>
                    <span class="cardZiduan">字段:<?= htmlspecialchars($card['setcode']) ?></span>
                    <span class="cardTypeAndLevel">
                        <span class="cardType"><?= htmlspecialchars($card['type']) ?></span>
                        <span class="cardLevel"><?= htmlspecialchars($card['level']) ?>☆</span>
                    </span>
                </div>
                <div class="cardLin3">
                    <img class="cardPic" src="https://mirror.ghproxy.com/https://raw.githubusercontent.com/FogMoe/YGOCustomCards/main/pics/<?= htmlspecialchars($card['id']) ?>.jpg" alt="<?= htmlspecialchars($card['name']) ?>">
                </div>
                <div class="cardLin4">
                    <textarea readonly class="cardMiaoshu">【<?= htmlspecialchars($card['race']) ?>】\n <?= htmlspecialchars($card['desc']) ?></textarea>
                </div>
                <div class="cardLin5">
                    <span class="cardAtk">ATK:<?= htmlspecialchars($card['atk']) ?></span>&nbsp;/&nbsp;<span class="cardDef">DEF:<?= htmlspecialchars($card['def']) ?></span>
                </div>
            <?php foreach ($cards as $card): ?>
        </div>




    </div>
    

 <!--   <table>
        <thead>
            <tr>
                <th>卡图</th>
                <th>ID</th>
                <th>名称</th>
                <th>描述</th>
                <th>字段</th>
                <th>类型</th>
                <th>ATK</th>
                <th>DEF</th>
                <th>等级</th>
                <th>种族</th>
                <th>属性</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cards as $card): ?>
            <tr>
                <td><img src="https://mirror.ghproxy.com/https://raw.githubusercontent.com/FogMoe/YGOCustomCards/main/pics/<?= htmlspecialchars($card['id']) ?>.jpg" alt="<?= htmlspecialchars($card['name']) ?>" width="100" height="145"/></td>
                <td><?= htmlspecialchars($card['id']) ?></td>
                <td><?= htmlspecialchars($card['name']) ?></td>
                <td><?= htmlspecialchars($card['desc']) ?></td>
                <td><?= htmlspecialchars($card['setcode']) ?></td>
                <td><?= htmlspecialchars($card['type']) ?></td>
                <td><?= htmlspecialchars($card['atk']) ?></td>
                <td><?= htmlspecialchars($card['def']) ?></td>
                <td><?= htmlspecialchars($card['level']) ?></td>
                <td><?= htmlspecialchars($card['race']) ?></td>
                <td><?= htmlspecialchars($card['attribute']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?<?= htmlspecialchars($previousPageUrl) ?>">上一页</a>
        <?php endif; ?>
        <?php if ($page < $totalPages && count($cards)>=10 ): ?>
            <a href="?<?= htmlspecialchars($nextPageUrl) ?>">下一页</a>
        <?php endif; ?>
    </div>
    <p>总共<?= $totalCards ?> 条数据，当前第 <?= $page ?> 页</p>
    <h4><a href="https://ygo.fog.moe/">点此返回FOGMOEYGO首页</a></h4>
    <footer>
        <a href="https://beian.miit.gov.cn/" target="_blank">鲁ICP备2022009156号-1</a>
        <br><br>
        <a href="https://fog.moe/" target="_blank">&copy; 2024 FOGMOE</a>
    </footer>
</body>
</html>
