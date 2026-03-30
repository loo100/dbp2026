# 🎓 小組協作作業說明

## 👥 小組協作規則

* **開發模式**：本次作業 **不需開啟分支 (Branch)**，全組成員請直接在 `main` 分支上進行開發。
* **評分機制**：老師將透過 GitHub 自動產生的 **Feedback Pull Request** 進行線上閱卷。
* **分工建議**：
    * **u1 (隊長)**：負責 ...。
    * **u2 (隊員)**：負責 ...。
    * **u3 (隊員)**：負責 ...。

---

## 🛠️ 開發前置設定 (必做！)

在開始撰寫程式碼之前，請每位成員在各自的 VS Code 終端機 (Terminal) 執行以下指令，確保 Commit 紀錄正確標記你的身分：

```bash
# 請根據你的身分修改引號內的內容
# 如果是自己的電腦，可使用 --global
git config --local user.name "你的名字 (例如: u1)"
git config --local user.email "你的學校信箱 (例如: u1@nuu.edu.tw)"
```
另外也請留意認證管理(當出現可以 commit 但無法 sync 時，通常都是認證問題，可找老師協助)。

## 💻 協作標準流程 (SOP)

為了避免程式碼被隊友覆蓋，請嚴格遵守 「先拉、再寫、後推」 的循環：

先拉 (Pull)：開始寫程式前，先點擊 VS Code 左下角的 「同步循環圖示」，取得隊友最新的進度。

再寫 (Work)：在 index.php 或 style.css 中進行開發。

記錄 (Commit)：完成一個階段後，在左側「原始碼控制」輸入訊息（例如：完成 PHP 計算功能）並按 Commit。

後推 (Sync/Push)：再次點擊同步按鈕，將你的程式碼送到 GitHub。

### ⚠️ 如果遇到「衝突 (Conflict)」怎麼辦？
當你跟隊友改到同一行時，VS Code 會跳出紅色衝突警告。

#### 處理步驟：

1. 點選 「接受兩者變更 (Accept Both Changes)」 (通常最安全)。

2. 手動調整好正確的程式碼後，存檔 (Save)。

3. 按下檔案旁的 「+」號 (Stage Change)，最後再執行 Commit 與 Sync。

## 📝 批改與回饋
老師將會在 GitHub 網頁上的 Pull Requests > Feedback 頁面進行批改。

* 如何查看回饋：登入 GitHub 作業網址，進入 Pull Requests 標籤，點擊名為 Feedback 的項目。

* 逐行討論：老師會在程式碼中留言，你們也可以在該處回覆老師的提問。


### ✅ 繳交清單
- [ ] 是否已正確設定 git config --local？

- [ ] 是否所有成員都有 Commit 貢獻紀錄（老師會檢查 Insights）？