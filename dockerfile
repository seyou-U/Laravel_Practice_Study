# PHPのバージョンが8.3系のため83に変更
FROM laravelsail/php83-composer AS base

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    python3 \
    python3-pip \
    && rm -rf /var/lib/apt/lists/*

# その後の処理についてはREAD MEを参照すること(Supervisor起動、動作確認)
