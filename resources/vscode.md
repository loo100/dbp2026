# laragon 綠色安裝

如果你將 Laragon 安裝在 D:\laragon，幾乎所有的執行檔、設定檔、資料庫檔案以及你的專案原始碼都會完整地存放在該目錄下，不會散落在 C: 槽的其他地方。
1. Laragon 的檔案結構
Laragon 的設計哲學是「乾淨」，它不像傳統安裝程式會把檔案丟到 C:\Windows 或 C:\Users\YourName\AppData。

設定檔：主要存在 D:\laragon\usr\laragon.ini。

網站設定：Apache 或 Nginx 的虛擬主機設定存在 D:\laragon\etc\apache2\sites-enabled 或 D:\laragon\etc\nginx\sites-enabled。

資料庫：你的 MySQL 資料存放於 D:\laragon\data\mysql。

二進位檔：PHP、MySQL、Apache 的執行程式都在 D:\laragon\bin 目錄下。

2. 唯一可能出現在 C: 的「痕跡」
雖然 Laragon 本身很乾淨，但在 Windows 運行時，有幾個例外可能會涉及 C:：

Hosts 檔案 (系統層級)： Laragon 有一個強大的功能是「自動虛擬主機 (Auto Virtual Hosts)」，它會自動修改 C:\Windows\System32\drivers\etc\hosts 檔案。這是為了讓你輸入 myproject.test 時，Windows 知道要導向本地伺服器。這是系統層級的行為，無法避免。

環境變數 (Path)： 如果你在選單中點擊了「Add Laragon to Path」，它會將 D:\laragon 的路徑加入到系統的環境變數中，這儲存在 Windows 註冊表 (Registry) 裡，但不佔用硬碟空間。

暫存檔 (Temporary Files)： PHP 或 Apache 在運行時，有時會使用 Windows 預設的暫存資料夾（通常在 C:\Users\...\AppData\Local\Temp），但這在服務關閉後通常會消失或被系統自動清理。

3. 如何確認與修改
如果你希望連「虛擬主機網址」都不修改 C: 的系統檔案，你可以關閉該功能：

操作：右鍵點擊 Laragon 介面 -> Preferences (設定) -> 取消勾選 "Auto Virtual Hosts"。