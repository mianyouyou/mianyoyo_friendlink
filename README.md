# 友情链接（mianyoyo_friendlink）

作者：**棉悠悠**  
适配：**XIUNOX 1.1+**

管理并展示友情链接，支持页脚展示，可选顶栏展示。

## 功能

- 后台增删改友链：名称、URL、图标、排序
- 展示位置开关：页脚 / 顶栏（可分别开关）
- 列表缓存，减少重复查询
- 适配棉悠悠资源社主题与默认布局
- 中 / 繁 / 英语言包

## 安装

1. 复制到站点 `plugin/mianyoyo_friendlink/`
2. 后台 → 插件 → 安装并启用
3. 插件设置中维护友链列表与展示位置
4. 清 `tmp/`，硬刷新

## 要求

- XIUNOX `bbs_version` ≥ `1.1`

## 目录结构

```
conf.json / install.php / uninstall.php / upgrade.php / setting.php
hook/     # 页脚/顶栏注入、语言包
model/    # MianyoyoFriendlinkService
view/     # 后台设置页
static/   # 后台样式
```

## 许可

作者保留权利；用于自有 XIUNOX 站点部署与二次修改请保留作者署名。
