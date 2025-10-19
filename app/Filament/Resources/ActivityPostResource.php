<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityPostResource\Pages;
use App\Filament\Resources\ActivityPostResource\RelationManagers;
use App\Models\ActivityPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityPostResource extends Resource
{
    protected static ?string $model = ActivityPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '活動報告';

    protected static ?string $modelLabel = '活動報告';

    protected static ?string $pluralModelLabel = '活動報告一覧';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('投稿内容')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('タイトル')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('post_date')
                            ->label('投稿日')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('category')
                            ->label('カテゴリ')
                            ->options([
                                'adoption' => '譲渡報告',
                                'rescue' => '保護報告',
                                'event' => 'イベント報告',
                                'other' => 'その他',
                            ])
                            ->default('other')
                            ->required(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('公開する')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('本文')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label('内容')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('画像')
                    ->schema([
                        Forms\Components\FileUpload::make('images')
                            ->label('活動報告の写真')
                            ->image()
                            ->multiple()
                            ->maxFiles(10)
                            ->directory('activity-posts')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText('最大10枚まで。JPG、PNG形式。'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('タイトル')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\ImageColumn::make('images')
                    ->label('画像')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                Tables\Columns\TextColumn::make('post_date')
                    ->label('投稿日')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('カテゴリ')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'adoption' => 'success',
                        'rescue' => 'warning',
                        'event' => 'info',
                        'other' => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'adoption' => '譲渡報告',
                        'rescue' => '保護報告',
                        'event' => 'イベント報告',
                        'other' => 'その他',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('公開')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日時')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('カテゴリ')
                    ->options([
                        'adoption' => '譲渡報告',
                        'rescue' => '保護報告',
                        'event' => 'イベント報告',
                        'other' => 'その他',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('公開状態')
                    ->placeholder('全て')
                    ->trueLabel('公開のみ')
                    ->falseLabel('非公開のみ'),
                Tables\Filters\Filter::make('post_date')
                    ->form([
                        Forms\Components\DatePicker::make('posted_from')
                            ->label('投稿日(開始)'),
                        Forms\Components\DatePicker::make('posted_until')
                            ->label('投稿日(終了)'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['posted_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('post_date', '>=', $date),
                            )
                            ->when(
                                $data['posted_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('post_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('post_date', 'desc');
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
            'index' => Pages\ListActivityPosts::route('/'),
            'create' => Pages\CreateActivityPost::route('/create'),
            'edit' => Pages\EditActivityPost::route('/{record}/edit'),
        ];
    }
}
