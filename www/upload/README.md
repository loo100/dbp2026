# 上傳檔案

處理檔案與圖片上傳是全端開發中非常實用的功能。在 PHP 中，這涉及到 HTML 的 `enctype` 屬性以及 PHP 的 `$_FILES` 超全域變數。

## 1. HTML 表單的必要設定

要上傳檔案，HTML 表單必須具備以下兩個關鍵屬性：

- `method="POST"`：檔案資料很大，不能用 `GET`。
- `enctype="multipart/form-data"`：告訴瀏覽器這是二進位檔案上傳內容。

```html
<form action="upload.php" method="POST" enctype="multipart/form-data">
    選擇圖片: <input type="file" name="my_image" accept="image/*">
    <button type="submit">上傳</button>
</form>
```

## 2. PHP 後端處理邏輯（upload.php）

當檔案上傳時，PHP 會先將檔案存放在臨時目錄。我們必須使用 `move_uploaded_file()` 將它移至指定資料夾（例如 `uploads/`）。

```php
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['my_image'])) {
    $file = $_FILES['my_image'];

    // 1. 取得檔案資訊
    $fileName = $file['name'];        // 原始檔名
    $fileTmpName = $file['tmp_name']; // 暫存路徑
    $fileSize = $file['size'];        // 檔案大小
    $fileError = $file['error'];      // 錯誤代碼

    // 2. 檢查副檔名（安全性檢查）
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { // 限制 50MB
                // 3. 產生唯一檔名，避免重複覆蓋
                $newFileName = uniqid('', true) . '.' . $fileExt;
                $fileDestination = 'uploads/' . $newFileName;

                // 建立資料夾（如果不存在）
                if (!is_dir('uploads')) {
                    mkdir('uploads');
                }

                // 4. 移動檔案
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    echo '上傳成功！檔案位置: ' . $fileDestination;
                } else {
                    echo '移動檔案時出錯。';
                }
            } else {
                echo '檔案太大了！';
            }
        } else {
            echo '上傳過程中發生錯誤。';
        }
    } else {
        echo '不支援此檔案類型。';
    }
}
?>
```

## 3. 檔案上傳的三大安全關鍵

上傳功能是網站最容易受攻擊的地方（例如駭客可能嘗試上傳 `.php` 腳本接管伺服器）。

- 檢查 MIME 類型或副檔名：不要信任使用者提供的檔名，務必限制可上傳類型（如 `.jpg`、`.pdf`）。
- 重新命名檔案：使用 `uniqid()` 或 `md5()` 重新命名，防止路徑被預測或惡意檔名被執行。
- 限制檔案大小：防止超大檔案塞爆硬碟空間。在 php.ini 中，有上傳檔案大小限制的設定

## 4. 影像縮圖

上傳的圖片有時我們會製作較小的圖檔，用來作為目錄或快速檢視圖片。

範例 upload_1.php 可用來理解如何處理圖片大小。

我們也可以使用繪圖指令，在影像上加上文字或色彩形狀。

## 5. 如何與資料庫結合？

在資料庫中，不建議存圖片本體（會讓資料庫變慢），通常只存檔案路徑字串。

- 資料庫欄位：`image_path`（`VARCHAR`）
- 儲存內容：`uploads/658d123abc.jpg`
- 顯示方式：

```php
<img src="<?php echo $row['image_path']; ?>">
```

---

將「檔案上傳」與「資料庫關聯」結合，是全端開發中處理多媒體資料的標準做法。

為了實現這個功能，可以對之前的「雲端記事本」做三項調整：

1. 資料庫：在 `notes` 表增加一個欄位存放圖片路徑。
2. 前端：在表單加入檔案選取框。
3. 後端：處理圖片上傳，並將路徑存入資料庫。

```sql
ALTER TABLE notes ADD COLUMN image_path VARCHAR(255) DEFAULT NULL;
```

相關檔案：`notes_with_image.php`

## 程式碼關鍵說明

- `image_path = null`：初始化變數，若未上傳圖片則資料庫欄位存 `NULL`。
- `uniqid('IMG_', true)`：產生如 `IMG_658d123.jpg` 的唯一檔名，避免同名檔案覆蓋。
- `img-fluid`（Bootstrap）：確保大圖片不會超出卡片寬度。
- `is_dir('uploads')`：自動檢查並建立資料夾，方便專案在新環境部署。

