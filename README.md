# Slog
Creating a Blog Design with Symfony, Vue.js, and Tailwind.

## Project Member
- Vu Dinh Dung
- Tran Xuan Thanh

## Requirements
`PHP 8.2+` and `Nodejs 18`

## Hướng dẫn cài đặt

### Yêu cầu hệ thống:
Hệ điều hành Ubuntu 20.04+ hoặc WSL (Windows).

### Các công cụ chính*

```bash
sudo add-apt-repository ppa:ondrej/php &&\
sudo apt-get install php8.2-{common,curl,mbstring,xml,zip,sqlite3}
```

```bash
curl -sS https://getcomposer.org/installer | php -- --install-dir=$HOME/.local/bin --filename=composer &&\
curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash &&\
sudo apt install symfony-cli
```

```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash - &&\
sudo apt-get install -y nodejs
```

### Các công cụ tùy chọn
```bash
pip install djlint
```
