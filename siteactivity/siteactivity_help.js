// TRANSACTION 도움말

function explain_TRANSFER(){
    Swal.fire({
        icon: 'question',
        title: '도움말',
        text: 'TRANSFER',
        footer: '<b>사용자 간 마이페이지의 EXP 송금 기능을 통해 EXP를 주고받은 경우에 해당하는 거래 종류입니다.'
                + '따라서 EXP를 준 유저(FROM)와 받은 유저(TO)가 반드시 존재합니다.</b>'
    })
}

function explain_ID(){
    Swal.fire({
        icon: 'question',
        title: '도움말',
        text: 'ID',
        footer: '<b>송수신측간 이루어진 거래에 대한 정보를 한 문자열로 취합하여 SHA256처리한 고유 거래 번호입니다.'
                + 'sha256($거래타입 + $송신자ID + $수신자ID + $거래량(정수) + $거래일시(Y-m-d H:i:s.u));와 같이 저장됩니다.' 
                + '자세한 내용은 Github에 올라간 공개 코드를 참조해주세요.</b>'
    })
}

function explain_TRANSACTION_TIME(){
    Swal.fire({
        icon: 'question',
        title: '도움말',
        text: 'DATE',
        footer: '<b>당사자 간 거래가 성사된 일시입니다.</b>'
    })
}

function explain_FROM(){
    Swal.fire({
        icon: 'question',
        title: '도움말',
        text: 'FROM',
        footer: '<b>EXP를 송금한 사람의 ID입니다.</b>'
    })
}

function explain_TO(){
    Swal.fire({
        icon: 'question',
        title: '도움말',
        text: 'FROM',
        footer: '<b>EXP를 송금받은 사람의 ID입니다.</b>'
    })
}

function explain_AMOUNT(){
    Swal.fire({
        icon: 'question',
        title: '도움말',
        text: 'AMOUNT',
        footer: '<b>송금한 EXP의 양입니다. 최소단위는 1EXP이며 양의 정수입니다.</b>'
    })
}
