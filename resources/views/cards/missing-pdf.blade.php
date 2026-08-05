<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #1a1a1a; }
        .header { text-align: center; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #eab308; }
        .header h1 { margin: 0; font-size: 18px; color: #eab308; }
        .header p { margin: 4px 0 0; color: #666; font-size: 10px; }
        .stats { display: flex; justify-content: space-around; margin-bottom: 15px; background: #f9fafb; padding: 8px; border-radius: 4px; }
        .stat { text-align: center; }
        .stat-value { font-size: 16px; font-weight: bold; color: #eab308; }
        .stat-label { font-size: 8px; color: #666; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; font-size: 9px; }
        th { background: #1f2937; color: #eab308; padding: 4px 6px; text-align: left; text-transform: uppercase; font-size: 8px; }
        td { padding: 3px 6px; border-bottom: 1px solid #e5e7eb; }
        tr:nth-child(even) { background: #f9fafb; }
        .rarity-badge { display: inline-block; padding: 1px 4px; border-radius: 2px; font-size: 7px; font-weight: bold; color: white; }
        .color-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; vertical-align: middle; margin-right: 3px; }
        .footer { margin-top: 15px; text-align: center; font-size: 8px; color: #999; border-top: 1px solid #e5e7eb; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>One Piece TCG — Cartas Faltantes</h1>
        <p>Generado el {{ date('d/m/Y H:i') }} — Usuario: {{ auth()->user()->name }}</p>
    </div>

    <div class="stats">
        <div class="stat">
            <div class="stat-value">{{ $totalCatalog }}</div>
            <div class="stat-label">Catálogo</div>
        </div>
        <div class="stat">
            <div class="stat-value">{{ $ownedCount }}</div>
            <div class="stat-label">Coleccionadas</div>
        </div>
        <div class="stat">
            <div class="stat-value" style="color: #ef4444;">{{ $missingCount }}</div>
            <div class="stat-label">Faltantes</div>
        </div>
        <div class="stat">
            <div class="stat-value">{{ number_format(($ownedCount / $totalCatalog) * 100, 1) }}%</div>
            <div class="stat-label">Completado</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>Carta</th>
                <th>Personaje</th>
                <th>Set</th>
                <th>Color</th>
                <th>Tipo</th>
                <th>Rareza</th>
            </tr>
        </thead>
        <tbody>
            @foreach($missingCards as $card)
            <tr>
                <td>{{ $card->card_number }}</td>
                <td><strong>{{ $card->name }}</strong>
                @if($card->name_es)
                <br><span style="color: #eab308; font-size: 8px;">{{ $card->name_es }}</span>
                @endif</td>
                <td>{{ $card->character ?? '—' }}
                @if($card->character_es)
                <br><span style="color: #666; font-size: 8px;">{{ $card->character_es }}</span>
                @endif</td>
                <td>{{ $card->set->code }}</td>
                <td>
                    @php
                        $colorMap = [
                            '赤' => ['Rojo', '#ef4444'],
                            '緑' => ['Verde', '#22c55e'],
                            '青' => ['Azul', '#3b82f6'],
                            '紫' => ['Morado', '#a855f7'],
                            '黒' => ['Negro', '#1f2937'],
                            '黄' => ['Amarillo', '#eab308'],
                            '多色' => ['Multicolor', '#6b7280'],
                        ];
                        $colorInfo = $colorMap[$card->color] ?? ['Desconocido', '#6b7280'];
                    @endphp
                    <span class="color-dot" style="background: {{ $colorInfo[1] }};"></span>{{ $colorInfo[0] }}
                </td>
                <td>{{ $card->type }}</td>
                <td>
                    @if($card->rarity)
                        <span class="rarity-badge" style="background: {{ $card->rarity->color }};">{{ $card->rarity->name }}</span>
                    @else
                        —
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        One Piece TCG Collection Manager — {{ date('Y') }}
    </div>
</body>
</html>