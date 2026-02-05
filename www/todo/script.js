// script.js

document.addEventListener('DOMContentLoaded', function() {
    // 1. 選取 HTML 元素
    const input = document.getElementById('todoInput');
    const addBtn = document.getElementById('addBtn');
    const todoList = document.getElementById('todoList');

    // 2. 定義新增項目的函數
    function addTask() {
        const taskText = input.value.trim(); // 取得輸入值並移除前後空白

        if (taskText === "") {
            alert("請輸入內容！");
            return;
        }

        // 建立一個新的 <li> 元素
        const li = document.createElement('li');
        li.innerHTML = `
            <span class="task-content">${taskText}</span>
            <button class="delete-btn">刪除</button>
        `;

        
        // 為刪除按鈕加入點擊事件
        li.querySelector('.delete-btn').addEventListener('click', function() {
            li.remove(); // 移除該筆待辦事項
        });
        // --- 新增功能：點擊文字切換完成狀態 ---
        const span = li.querySelector('.task-content');
        span.addEventListener('click', function() {
            // toggle 會檢查：如果有這個 class 就移除，沒有就加上
            span.classList.toggle('completed');
        });
        // ----------------------------------

        // 將 <li> 加入到 <ul> 中
        todoList.appendChild(li);

        // 清空輸入框
        input.value = "";
    }

    // 3. 綁定按鈕點擊事件
    addBtn.addEventListener('click', addTask);

    // (進階) 支援按下 Enter 鍵也能新增
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            addTask();
        }
    });
});