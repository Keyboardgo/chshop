<?php
include("../includes/common.php");
$title='AI对话助手';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");





$ai_config = [];
$ai_config_keys = ['deepseek_api_key', 'deepseek_model'];
$stmt = $DB->query("SELECT * FROM pre_config WHERE k IN ('".implode("','", $ai_config_keys)."')");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $ai_config[$row['k']] = $row['v'];
}


if(!isset($ai_config['deepseek_model']) || empty($ai_config['deepseek_model'])) {
    $ai_config['deepseek_model'] = 'deepseek-chat';
}
?>

<style>
:root {
    --primary-color: #00c3ff;
    --secondary-color: #7000ff;
    --bg-dark: #0f1a2e;
    --bg-light: #1a2942;
    --text-light: #e0f2ff;
    --text-dim: #8ba3c7;
    --accent-color: #00eeff;
    --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    --gradient-dark: linear-gradient(135deg, #0a1525, #1e2f4d);
    --glow-effect: 0 0 10px rgba(0, 195, 255, 0.5);
    --border-radius: 12px;
    --message-radius: 16px;
    --animation-speed: 0.3s;
}

body {
    background-color: var(--bg-dark);
    color: var(--text-light);
}

.block {
    background: var(--gradient-dark);
    border-radius: var(--border-radius);
    border: 1px solid rgba(0, 195, 255, 0.2);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2), var(--glow-effect);
    overflow: hidden;
    backdrop-filter: blur(10px);
}

.block-title {
    background: rgba(0, 0, 0, 0.2);
    border-bottom: 1px solid rgba(0, 195, 255, 0.2);
    padding: 15px 20px;
}

.block-title h3 {
    color: var(--accent-color);
    font-weight: 500;
    margin: 0;
    display: flex;
    align-items: center;
}

.block-title h3:before {
    content: "";
    display: inline-block;
    width: 8px;
    height: 8px;
    background: var(--accent-color);
    border-radius: 50%;
    margin-right: 10px;
    box-shadow: 0 0 10px var(--accent-color);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 0.5; transform: scale(0.8); }
    50% { opacity: 1; transform: scale(1.2); }
    100% { opacity: 0.5; transform: scale(0.8); }
}

.card-body {
    padding: 20px;
}

.chat-container {
    height: 600px;
    overflow-y: auto;
    border-radius: var(--border-radius);
    padding: 20px;
    margin-bottom: 20px;
    background-color: rgba(15, 26, 46, 0.7);
    border: 1px solid rgba(0, 195, 255, 0.1);
    box-shadow: inset 0 0 30px rgba(0, 0, 0, 0.3);
    scrollbar-width: thin;
    scrollbar-color: var(--primary-color) rgba(26, 41, 66, 0.5);
}

.chat-container::-webkit-scrollbar {
    width: 6px;
}

.chat-container::-webkit-scrollbar-track {
    background: rgba(26, 41, 66, 0.5);
    border-radius: 3px;
}

.chat-container::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: 3px;
}

.chat-message {
    margin-bottom: 25px;
    display: flex;
    transition: all var(--animation-speed) cubic-bezier(0.17, 0.67, 0.83, 0.67);
    opacity: 0;
    transform: translateY(10px);
    animation: messageAppear var(--animation-speed) forwards;
}

@keyframes messageAppear {
    to { opacity: 1; transform: translateY(0); }
}

.chat-message .avatar {
    width: 45px;
    height: 45px;
    margin-right: 15px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    flex-shrink: 0;
    position: relative;
    border: 2px solid rgba(0, 195, 255, 0.3);
}

.chat-message .avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.chat-message .avatar:after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0, 195, 255, 0.2), rgba(112, 0, 255, 0.1));
    z-index: 1;
}

.chat-message .message {
    flex: 1;
    padding: 15px 20px;
    border-radius: var(--message-radius);
    max-width: 80%;
    word-break: break-word;
    position: relative;
    overflow: hidden;
}

.chat-message.user {
    flex-direction: row-reverse;
}

.chat-message.user .avatar {
    margin-right: 0;
    margin-left: 15px;
    border-color: rgba(112, 0, 255, 0.3);
}

.chat-message.user .message {
    background: linear-gradient(135deg, var(--secondary-color), #4a00b4);
    color: white;
    border-top-right-radius: 4px;
    text-align: right;
    box-shadow: 0 5px 15px rgba(112, 0, 255, 0.2);
}

.chat-message.user .message:before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 20px;
    height: 20px;
    background: var(--secondary-color);
    border-radius: 0 0 0 10px;
    z-index: -1;
}

.chat-message.ai .message {
    background: linear-gradient(135deg, #1a2942, #2a3b55);
    color: var(--text-light);
    border-top-left-radius: 4px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 195, 255, 0.2);
}

.chat-message.ai .message:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 20px;
    height: 20px;
    background: var(--primary-color);
    border-radius: 0 0 10px 0;
    z-index: -1;
}

.chat-message .avatar .deepseek-logo {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    position: relative;
    overflow: hidden;
}

.chat-message .avatar .deepseek-logo:before {
    content: '';
    position: absolute;
    width: 150%;
    height: 150%;
    background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 70%);
    top: -25%;
    left: -25%;
    opacity: 0.1;
    animation: shine 3s infinite linear;
}

@keyframes shine {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.chat-message .avatar .deepseek-logo svg {
    width: 28px;
    height: 28px;
    filter: drop-shadow(0 0 3px rgba(255, 255, 255, 0.7));
}

.chat-form {
    display: flex;
    margin-top: 25px;
    position: relative;
}

.chat-form:before {
    content: '';
    position: absolute;
    top: -10px;
    left: 10px;
    right: 10px;
    height: 1px;
    background: linear-gradient(to right, transparent, var(--primary-color), transparent);
}

.chat-form textarea {
    flex: 1;
    border-radius: 20px 0 0 20px;
    resize: none;
    border: none;
    padding: 15px 20px;
    background: rgba(26, 41, 66, 0.7);
    color: var(--text-light);
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(0, 195, 255, 0.2);
    transition: all var(--animation-speed) ease;
    font-family: inherit;
}

.chat-form textarea:focus {
    outline: none;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.2), 0 0 0 2px var(--primary-color), var(--glow-effect);
    background: rgba(26, 41, 66, 0.9);
}

.chat-form textarea::placeholder {
    color: var(--text-dim);
}

.chat-form button {
    border-radius: 0 20px 20px 0;
    padding: 0 25px;
    background: var(--gradient-primary);
    border: none;
    color: white;
    font-weight: 500;
    letter-spacing: 0.5px;
    box-shadow: 0 5px 15px rgba(0, 195, 255, 0.3);
    transition: all var(--animation-speed) ease;
    position: relative;
    overflow: hidden;
}

.chat-form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 20px rgba(0, 195, 255, 0.4);
}

.chat-form button:active {
    transform: translateY(1px);
    box-shadow: 0 3px 10px rgba(0, 195, 255, 0.3);
}

.chat-form button:before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 70%);
    opacity: 0;
    transition: opacity 0.5s ease;
}

.chat-form button:hover:before {
    opacity: 1;
    animation: ripple 1s linear;
}

@keyframes ripple {
    from { transform: scale(0.5); opacity: 1; }
    to { transform: scale(2); opacity: 0; }
}

.chat-message .message pre {
    white-space: pre-wrap;
    background: rgba(15, 26, 46, 0.7);
    color: var(--text-light);
    padding: 15px;
    border-radius: 8px;
    margin-top: 12px;
    font-size: 14px;
    border-left: 3px solid var(--accent-color);
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.2);
    font-family: 'Consolas', 'Monaco', monospace;
}

.chat-message .message p {
    margin-bottom: 10px;
    line-height: 1.5;
}

.chat-message .message p:last-child {
    margin-bottom: 0;
}

.system-message {
    text-align: center;
    margin: 15px 0;
    color: var(--text-dim);
    font-size: 13px;
    background: rgba(26, 41, 66, 0.5);
    padding: 8px 15px;
    border-radius: 20px;
    display: inline-block;
    margin-left: auto;
    margin-right: auto;
    width: auto;
    max-width: 80%;
    border: 1px solid rgba(0, 195, 255, 0.1);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(5px);
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.system-message.error {
    color: #ff6b6b;
    background-color: rgba(255, 107, 107, 0.1);
    border: 1px solid rgba(255, 107, 107, 0.3);
}

.system-message .retry-btn {
    margin-left: 10px;
    padding: 2px 10px;
    font-size: 12px;
    background: linear-gradient(135deg, #ff6b6b, #ff3a3a);
    border: none;
    border-radius: 12px;
    color: white;
    transition: all 0.3s ease;
}

.system-message .retry-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(255, 107, 107, 0.3);
}

.system-message-container {
    text-align: center;
    margin: 15px 0;
}

.loading {
    display: inline-block;
    width: 20px;
    height: 20px;
    position: relative;
    margin-left: 10px;
}

.loading:before,
.loading:after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: var(--accent-color);
    opacity: 0.6;
    animation: pulse-loading 2s infinite ease-in-out;
}

.loading:after {
    animation-delay: -1s;
}

@keyframes pulse-loading {
    0%, 100% { transform: scale(0); opacity: 0.6; }
    50% { transform: scale(1); opacity: 0; }
}

.toolbar {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    align-items: center;
    padding: 0 5px;
    position: relative;
}

.toolbar:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 5px;
    right: 5px;
    height: 1px;
    background: linear-gradient(to right, transparent, var(--primary-color), transparent);
}

.model-selector {
    margin-right: 15px;
    position: relative;
}

.model-selector:before {
    content: '模型';
    position: absolute;
    top: -20px;
    left: 10px;
    font-size: 12px;
    color: var(--accent-color);
}

.model-selector select {
    border-radius: 20px;
    padding: 8px 15px;
    background: rgba(26, 41, 66, 0.7);
    border: 1px solid rgba(0, 195, 255, 0.2);
    color: var(--text-light);
    appearance: none;
    padding-right: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.model-selector select:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 2px rgba(0, 238, 255, 0.3);
}

.model-selector:after {
    content: '▼';
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--accent-color);
    pointer-events: none;
    font-size: 10px;
}

.toolbar-buttons {
    display: flex;
}

#clearBtn {
    margin-right: 10px;
    background: rgba(26, 41, 66, 0.7);
    border: 1px solid rgba(0, 195, 255, 0.2);
    color: var(--text-light);
    border-radius: 20px;
    padding: 8px 15px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

#clearBtn:hover {
    background: rgba(0, 195, 255, 0.1);
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

#clearBtn i {
    color: var(--accent-color);
}

/* 响应式调整 */
@media (max-width: 768px) {
    .chat-container {
        height: 500px;
    }
    
    .chat-message .message {
        max-width: 85%;
    }
    
    .toolbar {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    
    .model-selector {
        margin-right: 0;
        margin-bottom: 10px;
    }
    
    .toolbar-buttons {
        justify-content: flex-end;
    }
}
</style>

<div class="col-xs-12 col-sm-10 col-lg-8 center-block">
    <div class="block">
        <div class="block-title">
            <h3 class="panel-title">AI对话助手 (DeepSeek)</h3>
        </div>
        <div class="card-body">
            <?php if(empty($ai_config['deepseek_api_key'])): ?>
            <div class="alert alert-warning">
                您还没有设置DeepSeek API密钥，请先在<a href="./ai_settings.php">大模型配置</a>中设置。
            </div>
            <?php else: ?>
            <div class="toolbar">
                <div class="model-selector">
                    <select class="form-control" id="modelSelect">
                        <option value="deepseek-chat" <?php echo $ai_config['deepseek_model'] == 'deepseek-chat' ? 'selected' : ''; ?>>DeepSeek-V3-0324</option>
                        <option value="deepseek-reasoner" <?php echo $ai_config['deepseek_model'] == 'deepseek-reasoner' ? 'selected' : ''; ?>>DeepSeek-R1-0528</option>
                    </select>
                </div>
                <div class="toolbar-buttons">
                    <button id="clearBtn" class="btn btn-default"><i class="fa fa-trash"></i> 清除会话</button>
                </div>
            </div>
            <div class="chat-container" id="chatContainer">
                <!-- 初始提示信息将由JavaScript动态添加 -->
            </div>
            <div class="chat-form">
                <textarea class="form-control" id="userInput" rows="3" placeholder="请输入您的问题..."></textarea>
                <button class="btn btn-primary" id="sendBtn"><i class="fa fa-paper-plane"></i> 发送</button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>

const deepseekLogoSvg = `<svg viewBox="0 0 1391 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><path d="M1382.12555807 63.45623157c-14.73053987-7.36694577-21.0903122 6.67482826-29.69569586 13.81050954-2.93270133 2.3025895-5.43639037 5.2956207-7.94007938 8.05738747-21.52435201 23.478369-46.67184703 38.90270222-79.56167359 37.06096578-48.0527304-2.76176674-89.0854117 12.66089063-125.34197943 50.18270947-7.71049077-46.26964801-33.3205147-73.89234293-72.3086842-91.61758983-20.43003543-9.20700638-41.0326813-18.41568859-55.33420887-38.44352498-9.95442626-14.27136261-12.66089063-30.15487307-17.66659288-45.80711909-3.16564161-9.43827083-6.33128325-19.10613027-16.97615117-20.71827809-11.59673901-1.84173644-16.11477489 8.05738745-20.66129987 16.34436353-18.12744594 33.83834596-25.17765995 71.1305762-24.45872917 108.88198365 1.55516963 84.94276158 36.71742076 152.6194535 106.52409176 200.73083796 7.94175522 5.52353348 9.98459118 11.04874282 7.48090216 19.10445442-4.74762451 16.57395213-10.44544426 32.68872704-15.42265737 49.2626792-3.16731744 10.58956558-7.91326613 12.89047925-19.04915208 8.28697605-38.29940365-16.34436352-71.39032974-40.51485003-100.65366161-69.74801697-49.63471329-49.03309056-94.5234779-103.12886155-150.48947443-145.4837722a661.8118183 661.8118183 0 0 0-39.90987567-27.85395942c-57.11729129-56.62794912 7.48090217-103.12718572 22.44438231-108.65239505 15.62375691-5.75479794 5.4380662-25.5513699-45.11835322-25.32178128s-96.79757829 17.49565827-155.72811695 40.51485003c-8.63052108 3.45220843-17.69675779 5.98438656-26.96074236 8.05738749-53.52096153-10.35997695-109.05459409-12.66089063-167.09359148-5.9860624-109.2556936 12.43130203-196.52953378 65.14618963-260.69536329 155.15163164-77.05798457 108.19154197-95.21559542 231.11697547-72.97231263 359.33467803 23.30743442 135.12547108 90.89698322 247.00048593 194.71628647 334.47374981 107.67371071 90.69588368 231.66329585 135.12547108 373.11837431 126.60890637 85.91977008-5.06603207 181.56605365-16.80521659 289.46935296-110.03495422 27.22049591 13.8121854 55.79338609 19.33739472 103.15735067 23.48004484 36.51464541 3.45220843 71.64840745-1.84173644 98.84041425-7.59653439 42.6146642-9.20700638 39.6501221-49.4922678 24.25595382-56.85753775-124.90961545-59.39139169-97.48802001-35.22090515-122.40592638-54.78621268 63.47538778-76.65578551 159.12167135-156.30460223 196.52953378-414.35215512 2.96286625-20.48701364 0.45917725-33.37749289 0-49.95144506-0.23126445-10.12871251 2.01267102-14.04344985 13.37982144-15.19306875 31.27767874-3.68347287 61.66381626-12.43130203 89.54626476-28.08354804 80.91239203-45.11835324 113.57095414-119.24196063 121.28312075-208.0977837 1.15129475-13.58092095-0.22958861-27.62269495-14.30152755-34.75837626M676.89467748 863.15361188c-121.02504304-97.14279917-179.75448214-129.13940867-204.01043596-127.75852533-22.67397092 1.38088338-18.588299 27.85395941-13.61108589 45.11835324 5.20847758 17.03480522 12.02742715 28.77398972 21.55116528 43.73746986 6.56254768 9.89912389 11.10907268 24.63133958-6.58768512 35.68008242-38.98984534 24.63133958-106.75368041-8.28697606-109.9176462-9.89744807-78.89972099-47.42094273-144.88047363-110.03495424-191.35122116-195.66648169-44.88708879-82.41058346-70.92780085-170.80555349-75.24473718-265.18491008-1.15129475-22.78960315 5.4380662-30.84699058 27.62437077-34.99131655a267.60145597 267.60145597 0 0 1 88.65304773-2.30091365c123.55889699 18.41736442 228.75740777 74.81404907 316.92111337 164.13072521 50.32683081 50.87147534 88.39497004 111.64375041 127.64289309 171.0351421 41.69463388 63.07151293 86.58339852 123.15334628 143.70068976 172.41434965 20.17028189 17.26439385 36.25489187 30.38613755 51.67754928 40.05399698-46.4707475 5.2956207-124.01639839 6.44523963-177.04801777-36.37052409m58.03732158-380.97298644c0-10.12871251 7.94343105-18.18609998 17.92634639-18.18609998q3.39523024 0.05865402 6.10001881 1.15129477a18.04197865 18.04197865 0 0 1 11.56824991 17.03480521 17.95483551 17.95483551 0 0 1-17.89785732 18.18609997 17.753736 17.753736 0 0 1-17.69675779-18.18609997m180.21533522 94.3793566c-11.53976081 4.83476764-23.10633489 8.97909357-34.24222086 9.43827083-17.20741563 0.92170613-36.02530325-6.21397518-46.21099397-14.96180432-15.88351045-13.58259677-27.22217175-21.17913115-31.96979625-44.88876463-2.04283596-10.12871251-0.92170613-25.78095852 0.89321705-34.75837629 4.08567191-19.33739472-0.46085308-31.7670209-13.8121854-43.04702813-10.87613241-9.20868221-24.71848271-11.74086034-39.90987566-11.74086036-5.66933063 0-10.87613241-2.5305023-14.73221569-4.60350318a15.10592564 15.10592564 0 0 1-6.56087184-21.17745534c1.5819829-3.22261982 9.29414949-11.05041866 11.10739683-12.43130199 20.62945915-11.97044896 44.42623571-8.05571162 66.40976495 0.92170611 20.40154635 8.51656469 35.79571462 24.17048652 58.03899743 46.269648 22.67397092 26.70266465 26.75964283 34.06961042 39.6501221 54.09577099 10.21585563 15.65224602 19.51000513 31.7670209 25.84128837 50.18103364 3.88289657 11.51127171-1.12280565 20.9478667-14.50262706 26.70266467" fill="#ffffff" /></svg>`;

$(document).ready(function() {
    let messages = [];
    const apiKey = '<?php echo $ai_config['deepseek_api_key']; ?>';
    let currentModel = $('#modelSelect').val();
    
    function saveMessages() {
        const chatData = {
            messages: messages,
            model: currentModel,
            timestamp: new Date().getTime()
        };
        localStorage.setItem('deepseek_chat_history', JSON.stringify(chatData));
    }
    
    function loadMessages() {
        const savedData = localStorage.getItem('deepseek_chat_history');
        if (savedData) {
            try {
                const chatData = JSON.parse(savedData);
                
                const now = new Date().getTime();
                const hoursDiff = (now - chatData.timestamp) / (1000 * 60 * 60);
                
                if (chatData.messages && chatData.messages.length > 0 && hoursDiff < 24) {
                    messages = chatData.messages;
                    
                    if (chatData.model) {
                        currentModel = chatData.model;
                        $('#modelSelect').val(currentModel);
                    }
                    
                    $('#chatContainer').html('');
                    
                    let userMessages = 0;
                    for (let i = 0; i < messages.length; i++) {
                        const msg = messages[i];
                        if (msg.role === 'user') {
                            appendMessage('user', msg.content);
                            userMessages++;
                        } else if (msg.role === 'assistant') {
                            appendMessage('ai', msg.content);
                        }
                    }
                    
                    if (userMessages > 0) {
                        appendSystemMessage('已恢复' + userMessages + '条历史对话');
                    } else {
                        appendSystemMessage('开始新的对话');
                    }
                    
                    return true;
                }
            } catch (e) {
                console.error('解析保存的聊天记录时出错', e);
            }
        }
        
        $('#chatContainer').html('');
        appendSystemMessage('开始新的对话');
        return false;
    }
    
    function sendMessage() {
        const userInput = $('#userInput').val().trim();
        if (!userInput) return;

        appendMessage('user', userInput);
        $('#userInput').val('');
        
        messages.push({role: "user", content: userInput});
        
        saveMessages();
        
        sendApiRequest();
    }
    
    function appendMessage(role, content) {
        let avatar;
        if (role === 'user') {
            avatar = '<div class="avatar"><img src="<?php echo ($conf['kfqq'])?'//q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$conf['kfqq'].'&src_uin='.$conf['kfqq'].'&fid='.$conf['kfqq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'../assets/img/user.png'?>" alt="User"></div>';
        } else {
            avatar = '<div class="avatar"><div class="deepseek-logo">' + deepseekLogoSvg + '</div></div>';
        }
        
        content = content.replace(/```([\s\S]*?)```/g, function(match, p1) {
            return '<pre>' + p1 + '</pre>';
        });
        
        content = content.split('\n').map(line => {
            if (!line.trim()) return '';
            if (line.startsWith('<pre>')) return line;
            return '<p>' + line + '</p>';
        }).join('');
        
        const messageHtml = `
            <div class="chat-message ${role}">
                ${avatar}
                <div class="message">${content}</div>
            </div>
        `;
        
        $('#chatContainer').append(messageHtml);
        scrollToBottom();
    }
    
    function appendSystemMessage(message, isError = false, allowRetry = false) {
        let systemHtml = `<div class="system-message-container"><div class="system-message${isError ? ' error' : ''}">${message}`;
        
        if (allowRetry) {
            systemHtml += ' <button class="btn btn-xs btn-warning retry-btn"><i class="fa fa-refresh"></i> 重试</button>';
        }
        
        systemHtml += `</div></div>`;
        
        const $message = $(systemHtml);
        $('#chatContainer').append($message);
        
        if (allowRetry) {
            $message.find('.retry-btn').click(function() {
                $message.remove();
                if (messages.length > 0) {
                    const lastUserMessage = messages.filter(msg => msg.role === 'user').pop();
                    if (lastUserMessage) {
                        sendApiRequest();
                    } else {
                        appendSystemMessage('没有找到可以重试的消息', true);
                    }
                }
            });
        }
        
        scrollToBottom();
    }
    
    function appendLoadingMessage() {
        const loadingHtml = `
            <div class="chat-message ai" id="loadingMessage">
                <div class="avatar"><div class="deepseek-logo">${deepseekLogoSvg}</div></div>
                <div class="message">正在思考<div class="loading"></div></div>
            </div>
        `;
        $('#chatContainer').append(loadingHtml);
        scrollToBottom();
    }
    
    function removeLoadingMessage() {
        $('#loadingMessage').remove();
    }
    
    function scrollToBottom() {
        const chatContainer = document.getElementById('chatContainer');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
    
    $('#sendBtn').click(sendMessage);
    $('#userInput').keypress(function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
    
    $('#clearBtn').click(function() {
        $('#chatContainer').html('<div class="system-message-container"><div class="system-message">开始新的对话</div></div>');
        messages = [];
        localStorage.removeItem('deepseek_chat_history');
    });
    
    $('#modelSelect').change(function() {
        currentModel = $(this).val();
        appendSystemMessage('已切换到模型: ' + (currentModel === 'deepseek-chat' ? 'DeepSeek-V3-0324' : 'DeepSeek-R1-0528'));
        saveMessages();
    });
    
    loadMessages();
    
    setTimeout(function() {
        $('#userInput').focus();
    }, 500);

    function sendApiRequest() {
        appendLoadingMessage();
        
        $.ajax({
            url: './ai_api.php',
            type: 'POST',
            data: {
                action: 'chat',
                model: currentModel,
                messages: JSON.stringify(messages)
            },
            success: function(response, status, xhr) {
                removeLoadingMessage();
                
                console.log('收到响应:', {
                    status: status,
                    contentType: xhr.getResponseHeader('Content-Type'),
                    responseType: typeof response
                });
                
                try {
                    let result;
                    
                    if (typeof response === 'object' && response !== null) {
                        result = response;
                    } else {
                        let cleanResponse = '';
                        if (typeof response === 'string') {
                            cleanResponse = response.replace(/[\x00-\x1F\x7F]/g, '').trim();
                        } else if (response !== null && response !== undefined) {
                            cleanResponse = String(response).trim();
                        }
                        
                        try {
                            result = JSON.parse(cleanResponse);
                        } catch (jsonError) {
                            const jsonStart = cleanResponse.indexOf('{');
                            const jsonEnd = cleanResponse.lastIndexOf('}');
                            
                            if (jsonStart !== -1 && jsonEnd !== -1 && jsonEnd > jsonStart) {
                                const jsonString = cleanResponse.substring(jsonStart, jsonEnd + 1);
                                try {
                                    result = JSON.parse(jsonString);
                                } catch (extractError) {
                                    throw new Error('无法解析API响应');
                                }
                            } else {
                                throw new Error('响应格式无效');
                            }
                        }
                    }
                    
                    if (result.success) {
                        appendMessage('ai', result.content);
                        
                        messages.push({role: "assistant", content: result.content});
                        
                        saveMessages();
                    } else {
                        const errorMsg = result.message || '请求失败';
                        appendSystemMessage('错误: ' + errorMsg, true, true);
                    }
                } catch (e) {
                    appendSystemMessage('解析响应时出错: ' + e.message, true, true);
                }
            },
            error: function(xhr, status, error) {
                removeLoadingMessage();
                
                const errorMsg = '请求API时出错: ' + status + ' - ' + (error || '未知错误');
                appendSystemMessage(errorMsg, true, true);
            },
            dataType: 'text',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            timeout: 60000,
            cache: false
        });
    }
});
</script>

<?php include './foot.php'; ?> 