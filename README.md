## About project

    โปรเจคนี้ใช้ laravel  framework ในการเขียน Backend API 
    เป็นเว็บอ่านนิยายออนไลน์ที่ผู้ใช้สามารถเข้ามาสร้างผลงานของตัวเองได้และเปิดให้
    ผู้อื่นอ่านผลงานของตัวเองและผู้ใช้จะสามารถกดติดตามผู้แต่งหรือเพิ่มนิยายที่ตัวเอง
    ชื่นชอบไปในชั้นหนังสือของตัวเองได้

## Install

    เปิด docker
    ถ้าเป็นของ Window ใช้ wsl
    ถ้าเป็น Mac ใช้ terminal ของ mac
    cd เข้าไปที่ไฟล์ที่ clone มา 

    cp .env.example .env

    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs


## Run

    alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'

    sail up -d

    sail artisan key:generate

    sail artisan migrate

    sail artisan jwt:secret

    sail artisan jwt:generate-certs --force --algo=rsa --bits=4096 --sha=512
