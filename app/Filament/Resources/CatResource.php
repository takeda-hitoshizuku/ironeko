<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatResource\Pages;
use App\Filament\Resources\CatResource\RelationManagers;
use App\Models\Cat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CatResource extends Resource
{
    protected static ?string $model = Cat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '保護猫';

    protected static ?string $modelLabel = '保護猫';

    protected static ?string $pluralModelLabel = '保護猫一覧';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('基本情報')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('名前')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('breed')
                            ->label('品種')
                            ->maxLength(255)
                            ->placeholder('例: 雑種、アメリカンショートヘア'),

                        Forms\Components\TextInput::make('age')
                            ->label('年齢')
                            ->placeholder('例: 2歳3ヶ月、生後6ヶ月')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('birthday')
                            ->label('誕生日')
                            ->placeholder('例: 2023年春頃、不明')
                            ->maxLength(255),
                        Forms\Components\Select::make('gender')
                            ->label('性別')
                            ->options([
                                'male' => 'オス',
                                'female' => 'メス',
                            ])
                            ->required(),
                        Forms\Components\Toggle::make('is_neutered')
                            ->label('避妊・去勢済み'),
                    ])->columns(2),

                Forms\Components\Section::make('外見')
                    ->schema([
                        Forms\Components\TextInput::make('fur_type')
                            ->label('毛質')
                            ->placeholder('例: 短毛、長毛')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('fur_color')
                            ->label('毛色')
                            ->placeholder('例: 三毛、キジトラ、白黒')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('eye_color')
                            ->label('目の色')
                            ->placeholder('例: 黄色、青、オッドアイ')
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('性格・健康')
                    ->schema([
                        Forms\Components\Textarea::make('personality')
                            ->label('性格')
                            ->placeholder('人懐っこさ、活発さ、他の猫との相性など')
                            ->rows(3),
                        Forms\Components\Textarea::make('health_info')
                            ->label('健康状態')
                            ->placeholder('ワクチン接種状況、病歴など')
                            ->rows(3),
                        Forms\Components\Textarea::make('description')
                            ->label('その他詳細')
                            ->rows(3),
                        Forms\Components\Textarea::make('reason_for_protection')
                            ->label('保護・譲渡理由')
                            ->placeholder('どのような経緯で保護されたか')
                            ->rows(3),
                    ]),

                Forms\Components\Section::make('ステータス')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('譲渡状況')
                            ->options([
                                'fostering' => '預かり前',
                                'available' => '募集中',
                                'reserved' => '予約済み',
                                'adopted' => '譲渡済み',
                            ])
                            ->default('fostering')
                            ->required(),
                        Forms\Components\DatePicker::make('protection_date')
                            ->label('保護日'),
                    ])->columns(2),
                Forms\Components\Section::make('画像')
                    ->schema([
                        Forms\Components\FileUpload::make('images')
                            ->label('猫の写真')
                            ->image()
                            ->multiple()
                            ->maxFiles(5)
                            ->directory('cats')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText('最大5枚まで。JPG、PNG形式。'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('名前')
                    ->searchable(),
                Tables\Columns\TextColumn::make('breed')
                    ->label('品種')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('images')
                    ->label('画像')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                Tables\Columns\TextColumn::make('age')
                    ->label('年齢')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('性別')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'male' => 'オス',
                        'female' => 'メス',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('is_neutered')
                    ->label('避妊去勢')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->label('状況')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'fostering' => 'info',
                        'available' => 'success',
                        'reserved' => 'warning',
                        'adopted' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'fostering' => '預かり前',
                        'available' => '募集中',
                        'reserved' => '予約済み',
                        'adopted' => '譲渡済み',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('protection_date')
                    ->label('保護日')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日時')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->contentGrid([
                'md' => 3,
                'xl' => 4,
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->label('性別')
                    ->options([
                        'male' => 'オス',
                        'female' => 'メス',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('譲渡状況')
                    ->options([
                        'fostering' => '預かり前',
                        'available' => '募集中',
                        'reserved' => '予約済み',
                        'adopted' => '譲渡済み',
                    ]),
                Tables\Filters\SelectFilter::make('fur_type')
                    ->label('毛質')
                    ->options([
                        '短毛' => '短毛',
                        '長毛' => '長毛',
                    ]),
                Tables\Filters\SelectFilter::make('fur_color')
                    ->label('毛色')
                    ->options(
                        fn(): array => \App\Models\Cat::query()
                            ->whereNotNull('fur_color')
                            ->distinct()
                            ->pluck('fur_color', 'fur_color')
                            ->toArray()
                    ),
                Tables\Filters\SelectFilter::make('eye_color')
                    ->label('目の色')
                    ->options(
                        fn(): array => \App\Models\Cat::query()
                            ->whereNotNull('eye_color')
                            ->distinct()
                            ->pluck('eye_color', 'eye_color')
                            ->toArray()
                    ),
                Tables\Filters\Filter::make('protection_date')
                    ->form([
                        Forms\Components\DatePicker::make('protected_from')
                            ->label('保護日(開始)'),
                        Forms\Components\DatePicker::make('protected_until')
                            ->label('保護日(終了)'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['protected_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('protection_date', '>=', $date),
                            )
                            ->when(
                                $data['protected_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('protection_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCats::route('/'),
            'create' => Pages\CreateCat::route('/create'),
            'edit' => Pages\EditCat::route('/{record}/edit'),
        ];
    }
}
