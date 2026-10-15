
import 'package:flutter_test/flutter_test.dart';
import 'package:ecole_eden/main.dart';

void main() {
  testWidgets('École Eden démarre correctement', (WidgetTester tester) async {
    await tester.pumpWidget(const EcoleEdenApp());
    await tester.pumpAndSettle();

    expect(find.byType(EcoleEdenApp), findsOneWidget);
  });
}
